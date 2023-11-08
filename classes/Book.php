<?php
namespace App;

class Book extends Dbh{
    public function add($name,$buyingLink, $language, $writter, $description, $tags, $cover, $category){
        if($cover != false){
            $response = $this->createRow(
                'books',
                ['`bookName`','`bookBuyingLink`', '`bookLanguage`', '`bookWritters`', '`bookDescription`','`bookTags`', '`bookCover`', '`bookCategory`'],
                'ssssssss',
                $name, $buyingLink, $language, $writter, $description, $tags, $cover, $category);
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

    public function update($bookId, $bookName, $buyingLink, $bookLanguage, $bookWritters, $bookCategory, $bookDescription, $bookTags){
        return $this->updateData(
            'books', 
            ['bookName', 'bookBuyingLink', 'bookLanguage', 'bookWritters', 'bookCategory', 'bookDescription', 'bookTags'],
            'sssssss', 
            'WHERE bookId='.$bookId,
            $bookName, $buyingLink, $bookLanguage, $bookWritters, $bookCategory, $bookDescription, $bookTags);
    }

    public function setCover($bookId, $bookCover){
        return $this->updateData('books', ['bookCover'], 's', 'WHERE bookId='.$bookId, $bookCover);
    }

    public function load(){
        $rows = $this->selectAll('books');
        if($rows !== false){
            $detailsLogo = file_get_contents(Application::$ROOT_DIR."/imgs/details.svg");
            foreach($rows as $row){
                echo "<div class='row' onclick='this.getElementsByTagName(\"a\")[0].click();'>
                    <div class='name'>".$row['bookName']."</div>
                    <div class='writter'>".$row['bookWritters']."</div>
                    <div class='downloads'>".$row['downloads']."</div>
                    <div class='clicks'>".$row['clicks']."</div>
                    <a href='".Application::$HOST."/admin/p/book-details/".$row['bookId']."' class='details'>$detailsLogo</a>
                    </div>";
            }
        }else{
            echo 'Nothing found!';
        }
    }

    //NOTE - Get a book's details by it's name
    public function getByName($bookName){
        // $bookName = str_replace('-', ' ', $bookName);
        $cache = new Cache;
        $cache = $cache->config();
        $cahceInstance = $cache->getItem("book?name=".str_replace(array('{', '}', '(', ')', '/','@', ':'), '', $bookName));
        if(is_null($cahceInstance->get())){
            $sql = "SELECT * FROM `books` WHERE `bookName`='{$bookName}';";
            $row = $this->getRows($sql)[0];
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
        $row = $this->getRows($sql);
        return $row;
    }

    //NOTE - Load popular books
    public function loadPopular($limit){
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
                        Books b
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
       
        foreach($rows as $row){
            $cover = Application::$HOST."/uploads/".$row['bookCover'];
            echo "<div class='top_book'>
                    <div class='top_book-cover'>
                        <img src='{$cover}'>
                    </div>
                    <div class='top_book-name'>{$row['bookName']}</div>
                    <div class='top_book-impressions'>{$row['clicks']}</div>
                    <div class='top_book-downloads'>{$row['downloads']}</div>
                </div>";
           
        }
    }

    //NOTE - Load popular books by language
    public function loadPopularByLanguage($limit, $language){
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
                        Books b

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
       
        foreach($rows as $row){
            $host = Application::$HOST;
            echo "<article class='slide' data-impression-collected=false data-book-category='{$row['bookCategory']}' data-book-id='{$row['bookId']}'>
                    <a href='{$host}/book/{$row['bookName']}'>
                    <div class='image-container' style='background-image: url({$host}/imgs/loading.gif)'>
                    <img loading='lazy' onload='this.style.opacity = 1' alt='{$row['bookName']} pdf by Magna Dokan' src='uploads/{$row['bookCover']}'>
                    </div>
                    <h3 class='name'>{$row['bookName']}</h3>
                    </a>
                </article>";
           
        }
    }

   

    //NOTE - Register when a book is clicked the help the algorithms
    public function click($bookId, $bookCategory){
        $clicks = $this->getById($bookId)['clicks']+1;
        $this->updateData('books', ['clicks'], 'i', " WHERE `bookId`='{$bookId}'", $clicks);
        require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
        $log = new Log;
        $log->collectClick($bookId, $bookCategory);
    }

    //NOTE - Download the pdf file if it's sotred on the server.(But not in use currently cause we store them on google drive)
    public function download($bookName){
        $downloads = $this->getByName($bookName)['downloads']+1;
        $this->updateData('books', ['downloads'], 'i', " WHERE `bookName`='{$bookName}'", $downloads);
    }

    public function request($requestFrom,$bookName, $bookWritters, $publicationYear, $note){
        return $this->createRow('bookRequests', ['requestFrom','bookName', 'bookWritters', 'bookPublicationYear', 'requestNote'], 'issis',$requestFrom, $bookName, $bookWritters, $publicationYear, $note);
    }
}