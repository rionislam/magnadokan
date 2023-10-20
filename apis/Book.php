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
    public function get($bookName){
        // $bookName = str_replace('-', ' ', $bookName);
        $cache = new Cache;
        $cache = $cache->config();
        $cahceInstance = $cache->getItem("book?name={$bookName}");
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
    public function count($condition){
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

    //NOTE - Load popular books of today by language
    public function loadPopularByLanguage($limit, $language){
        $cache = new Cache;
        $cache = $cache->config();
        $cahceInstance = $cache->getItem("books?language={$language}&limit={$limit}");
        if(is_null($cahceInstance->get())){
            $rows = $this->getLimited("0,".strval($limit) , "WHERE `bookLanguage` = '".$language."' ORDER BY `clicks` DESC, `downloads` DESC ");
            $cahceInstance->set($rows)->expiresAfter(43200);
            $cache->save($cahceInstance);
        }else{
            $rows = $cahceInstance->get();
        }
       
        foreach($rows as $row){
            $link = Application::$HOST."/book/".$row['bookName'];
            echo "<article class='swiper-slide'>
                    <a href='{$link}'>
                    <img loading='lazy' alt='{$row['bookName']} pdf by Magna Dokan' src='uploads/{$row['bookCover']}'>
                    <h3 class='name'>{$row['bookName']}</h3>
                    </a>
                </article>";
           
        }
    }

   

    //NOTE - Register when a book is clicked the help the algorithms
    public function click($bookName){
        $clicks = $this->get($bookName)['clicks']+1;
        $this->updateData('books', ['clicks'], 'i', " WHERE `bookName`='{$bookName}'", $clicks);
    }

    //NOTE - Download the pdf file if it's sotred on the server.(But not in use currently cause we store them on google drive)
    public function download($bookName){
        $downloads = $this->get($bookName)['downloads']+1;
        $this->updateData('books', ['downloads'], 'i', " WHERE `bookName`='{$bookName}'", $downloads);
    }

    public function request($requestFrom,$bookName, $bookWritters, $publicationYear, $note){
        return $this->createRow('bookRequests', ['requestFrom','bookName', 'bookWritters', 'bookPublicationYear', 'requestNote'], 'issis',$requestFrom, $bookName, $bookWritters, $publicationYear, $note);
    }
}