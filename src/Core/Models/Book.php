<?php
namespace Core\Models;

use Core\Application;
use Core\Services\ResourceLoader;
use Core\Services\Cache;
use Core\Services\ErrorHandler;

class Book extends Dbh{
    public function add($name,$pdfId, $language, $writter, $description, $tags, $cover, $category){
        if($cover != false){
            $response = $this->createRow(
                'books',
                ['`bookName`','`bookPdf`', '`bookLanguage`', '`bookWritters`', '`bookDescription`','`bookTags`', '`bookCover`', '`bookCategory`'],
                'ssssssss',
                $name, $pdfId, $language, $writter, $description, $tags, $cover, $category);
                return $response;
        
        }else{
            return false;
        }

    }

    public function setPdf($bookId, $pdfId){
        return $this->updateData(
            'books',
            ['bookPdf'],
            's', 
            'Where bookId='.$bookId,
            $pdfId);
    }

    public function update($bookId, $dataName, $data){
        return $this->updateData(
            'books', 
            ["{$dataName}"],
            's', 
            'WHERE bookId='.$bookId,
            $data);
    }

    public function setCover($bookId, $bookCover){
        return $this->updateData('books', ['bookCover'], 's', 'WHERE bookId='.$bookId, $bookCover);
    }

    public function getAll(){
        $rows = $this->selectAll('books');
        return $rows;
    }

    //NOTE - Get a book's details by it's name
    protected function getByName($bookName){
        $bookName = urldecode($bookName);
        $cache = new Cache;
        $cache = $cache->config();
        $cahceInstance = $cache->getItem("book?name=".str_replace(array('{', '}', '(', ')', '/','@', ':'), '', $bookName));
        if(is_null($cahceInstance->get())){
            $sql = "SELECT * FROM `books` WHERE `bookName`='{$bookName}';";
            $rows = $this->getRows($sql);
            if($rows == false){
                ErrorHandler::displayErrorPage(606);
                exit();
            }
            $row = $rows[0];
            $cahceInstance->set($row)->expiresAfter(43200);
            $cache->save($cahceInstance);
        }else{
            $row = $cahceInstance->get();
        }
        
        return $row;
    }

    //NOTE - Get a book's details by it's id
    public function getById($bookId){
        $sql = 'SELECT * FROM `books` WHERE `bookId`="'.$bookId.'";';
        $row = $this->getRows($sql)[0];
        return $row;
    }

    //NOTE - Get the number of books added to the database
    public function count($condition = NULL){
        $sql= "SELECT * FROM `books` {$condition};";
        $result = $this->getResult($sql);
        return $result->num_rows;
    }

    //NOTE - Get a limited list of books
    public function getLimited($limit, $condition){
        $sql = "SELECT * FROM `books` {$condition} Limit {$limit};";
        $rows = $this->getRows($sql);
        return $rows;
    }


    //NOTE - Load popular books
    public function getPopular($limit){
        $cache = new Cache;
        $cache = $cache->config();
        $cahceInstance = $cache->getItem("books?limit={$limit}");
        if(is_null($cahceInstance->get())){
            $sql = "SELECT
                        b.*,
                        COALESCE(SUM(CASE 
                                        WHEN bl.event = 'impression' THEN 1 
                                        WHEN bl.event = 'click' THEN 2
                                        WHEN bl.event = 'download' THEN 2
                                        ELSE 0 END
                                    ), 0) AS total_score
                    FROM
                        books b
                    LEFT JOIN
                        bookLogs bl ON b.bookId = bl.bookId AND bl.logTime >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    GROUP BY
                        b.bookId
                    ORDER BY
                        total_score DESC
                    LIMIT
                        {$limit};";
            $rows = $this->getRows($sql);
            $cahceInstance->set($rows)->expiresAfter(43200);
            $cache->save($cahceInstance);
        }else{
            $rows = $cahceInstance->get();
        }
       
        return $rows;
    }

   

    //NOTE - Load popular books by language
    public function getPopularByLanguage($limit, $language){
        $cache = new Cache;
        $cache = $cache->config();
        $cahceInstance = $cache->getItem("books?language={$language}&limit={$limit}");
        if(is_null($cahceInstance->get())){
            $sql = "SELECT
                        b.*,
                        COALESCE(SUM(CASE 
                                        WHEN bl.event = 'impression' THEN 1 
                                        WHEN bl.event = 'click' THEN 2
                                        WHEN bl.event = 'download' THEN 2
                                        ELSE 0 END
                                    ), 0) AS total_score
                    FROM
                        books b

                    LEFT JOIN
                        bookLogs bl ON b.bookId = bl.bookId AND bl.logTime >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)

                    WHERE 
                        b.bookLanguage = '{$language}'
                        
                    GROUP BY
                        b.bookId
                    
                    ORDER BY
                        total_score DESC

                    LIMIT
                        {$limit};";
            $rows = $this->getRows($sql);
            $cahceInstance->set($rows)->expiresAfter(43200);
            $cache->save($cahceInstance);
        }else{
            $rows = $cahceInstance->get();
        }
       
        return $rows;
    }

   

    //NOTE - Register when a book is clicked the help the algorithms
    // public function click($bookId, $bookCategory){
    //     if(!isset($_COOKIE['clicked'])){
    //         setcookie( 'clicked', 1, time() + 300, $_SERVER['REQUEST_URI'], $_SERVER['HTTP_HOST'], false);
    //         $clicks = $this->getById($bookId)['clicks']+1;
    //         $this->updateData('books', ['clicks'], 'i', " WHERE `bookId`='{$bookId}'", $clicks);
    //         require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
    //         $log = new Log;
    //         $log->collectClick($bookId, $bookCategory);
    //     }
        
    // }

    //NOTE - Download the pdf file if it's sotred on the server.(But not in use currently cause we store them on google drive)
    public function download($bookName){
        $downloads = $this->getByName($bookName)['downloads']+1;
        $this->updateData('books', ['downloads'], 'i', " WHERE `bookName`='{$bookName}'", $downloads);
    }

    public function request($requestFrom,$bookName, $bookWritters, $publicationYear, $note){
        return $this->createRow('bookRequests', ['requestFrom','bookName', 'bookWritters', 'bookPublicationYear', 'requestNote'], 'issis',$requestFrom, $bookName, $bookWritters, $publicationYear, $note);
    }
}