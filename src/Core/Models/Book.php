<?php
namespace Core\Models;

use Core\Utilities\Cache;
use Core\Services\ErrorHandler;
use Core\Utilities\DataConverter;
use Core\Utilities\Timer;

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
        $cacheInstance = $cache->getItem("book?name=".str_replace(array('{', '}', '(', ')', '/','@', ':'), '', $bookName));
        if(is_null($cacheInstance->get())){
            $sql = "SELECT * FROM `books` WHERE `bookName`='{$bookName}';";
            $rows = $this->getRows($sql);
            if($rows == false){
                ErrorHandler::displayErrorPage(606);
                exit();
            }
            $row = $rows[0];
            $description = DataConverter::markdownToText($row['bookDescription']);
            $description = str_replace(["\r\n", "\r"], "\n", $description);
            $paras= preg_split('/\s*\n+\s*/', $description, 2, PREG_SPLIT_DELIM_CAPTURE);
            $metaDescription = isset($paras[0]) ? $paras[0] : '';
            $row['metaDescription'] = $metaDescription;
            $cacheInstance->set($row)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
        }else{
            $row = $cacheInstance->get();
        }
        
        return $row;
    }

    //NOTE - Get a book's details by it's id
    public function getById($bookId){
        $sql = 'SELECT * FROM `books` WHERE `bookId`="'.$bookId.'";';
        $row = $this->getRows($sql)[0];
        return $row;
    }

    protected function getFourRelatedsById($bookId){
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem("relatedBooks?id={$bookId}");
        if(is_null($cacheInstance->get())){
            $sql ="(
                SELECT
                    b.bookId
                FROM
                    books b
                INNER JOIN (
                    SELECT
                        *
                    FROM
                        books
                    WHERE
                        bookId = {$bookId}
                ) p ON b.bookId != p.bookId
                WHERE
                    b.bookCategory LIKE CONCAT('%', p.bookCategory, '%')
                    OR b.bookWritters LIKE CONCAT('%', p.bookWritters, '%')
                    OR b.bookName LIKE CONCAT('%', p.bookName, '%')
                    OR b.bookDescription LIKE CONCAT('%', p.bookDescription, '%')
                    OR b.bookTags LIKE CONCAT('%', p.bookTags, '%')
                LIMIT 4
            )
            UNION
            (
                SELECT
                   books.bookId
                FROM
                    books
                WHERE
                    bookId != {$bookId}
                ORDER BY
                    RAND()
                LIMIT 4
            )
            LIMIT 4;";
            $rows = $this->getRows($sql);
            $cacheInstance->set($rows)->expiresAfter(Timer::timeLeftForNextMonth());
            $cache->save($cacheInstance);
        }else{
            $rows = $cacheInstance->get();
        }
        $books = array();
        foreach($rows as $row){
            $cache = new Cache;
            $cache = $cache->config();
            $cacheInstance = $cache->getItem("book?id={$row['bookId']}");
            $book = '';
            if(is_null($cacheInstance->get())){
                $book = $this->getById($row['bookId']);
                $cacheInstance->set($book)->expiresAfter(Timer::timeLeftForNextDay());
                $cache->save($cacheInstance);
            }else{
                $book = $cacheInstance->get();
            }
            array_push($books, $book);
        }
        return $books;
    }

    //NOTE - Get the number of books added to the database
    public function count($condition = NULL){
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem("booksCount?condition={$condition}");
        if(is_null($cacheInstance->get())){
            $sql= "SELECT * FROM `books` {$condition};";
            $result = $this->getResult($sql);
            $cacheInstance->set($result->num_rows)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
            return $result->num_rows;
        }else{
            return $cacheInstance->get();
        }
        
        
        
    }

    //NOTE - Get a limited list of books
    public function getLimited($limit, $condition){
        $sql = "SELECT * FROM `books` {$condition} Limit {$limit};";
        $rows = $this->getRows($sql);
        return $rows;
    }


    //NOTE - Load popular books
    protected function getPopular($limit){
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem("popularBooks?limit={$limit}");
        if(is_null($cacheInstance->get())){
            $sql = "SELECT
                        b.*,
                        COALESCE(SUM(CASE 
                                        WHEN bl.event = 'download' THEN 1
                                        ELSE 0 END), 0) AS downloads,
                        COALESCE(SUM(CASE 
                                        WHEN bl.event = 'click' THEN 1
                                        ELSE 0 END), 0) AS clicks,
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
            $cacheInstance->set($rows)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
        }else{
            $rows = $cacheInstance->get();
        }
       
        return $rows;
    }

   

    //NOTE - Load popular books by language
    public function getPopularByLanguage($limit, $language){
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem("books?language={$language}&limit={$limit}");
        if(is_null($cacheInstance->get())){
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
            $cacheInstance->set($rows)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
        }else{
            $rows = $cacheInstance->get();
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