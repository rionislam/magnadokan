<?php

@session_start();
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
new App\Application;
$book = new App\Book;
$title = 'All Books';
$condition = 'ORDER BY `bookId` DESC';
$keyword = '';
if(isset($_GET['language'])){
    $condition = "WHERE `bookLanguage`= '{$_GET['language']}' ORDER BY `bookId` DESC";
    $title = $_GET['language']." books";
}
if(isset($_GET['category'])){
    $condition = "WHERE `bookCategory`= '{$_GET['category']}' ORDER BY `bookId` DESC";
    $title = $_GET['category']." books";
}
if(isset($_GET['search'])){
    $keyword = $_GET['search'];
    $title = "Search Result for '{$_GET['search']}'";
    $search = new Search;
    $condition = $search->createCondition($_GET['search']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="var(--accent-1)" />
    <title><?=$title?> | Magna Dokan</title>
    <base href="<?=App\Application::$HOST?>/"/>
    <meta name="description" content="We provide free pdf version of books to those people who can't affort to buy the original copy of the books. You can 
                pdf of any book from our website for free. Although we always suggest to buy the real copy of the book.
                We do it all for educational purpous only. We also promote the original copy of the books we provide through our
                website. Most of the writters and pubblisher don't mind if their books are distributed to the underprivileged people
                for free. If anyone mind and don't want their content to be distributed for free they can place a request and we will 
                remove their content according to the DMCA policy.">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="<?=App\Application::$HOST?>/menifest.json">
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/css/global.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/functions.js"></script>
</head>
<body>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9CHSKS37J3"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-9CHSKS37J3');
    </script>
    <?php include "includes/login-signup.inc.php"?>
    <main>
        <?php include "includes/header.inc.php"?>
        <section class="books max-width center">
            <header>
                <div class="title"><?=$title?></div>
                <div class="short-by">
                    <label for="short-by">Short by:</label>
                    <select name="short-by" id="short-by">
                        <option value="latest" selected>Latest</option>
                        <option value="Popularity">Popularity</option>
                    </select>
                </div>
            </header>
            <hr>
            <div class="books-container">
                <?php
                $starting = 0;
                $limit = 12;
                $page = 1;

                $count = $book->count($condition);
                $pages = ceil( $count/$limit);
                
                if(isset($_GET['page'])){
                    if($_GET['page'] > 1){
                        $starting .= $limit;
                        $limit = $limit*$_GET['page'];
                        $page = $_GET['page'];
                    }
                }
                
                $rows = $book->getLimited("{$starting},{$limit}",$condition);
                if(is_array($rows)){
                    foreach($rows as $row){
                        $link = App\Application::$HOST."/book/".$row['bookName'];//str_replace(' ','-',$row['bookName']);
                    echo "<article>
                            <a href='{$link}'>
                            <img src='uploads/{$row['bookCover']}'>
                            <h3 class='name'>{$row['bookName']}</h3>
                            </a>
                        </article>";
                    }
                }else{
                    echo 'Nothing found!';
                }
                

                    
                ?>
            </div>
            <div class="paginations">
            <?php
            for($i = 1; $i<=$pages; $i++){
                echo "<a href='".App\Application::$HOST."/books/page={$i}".(($keyword != '')? "&search={$keyword}": "")."'><div class='pagination ".(($i == $page) ? 'active':'')."'>
                        {$i}
                    </div></a>";
            }
            ?>
            </div>
           
        </section>
    </main>
    <?php include "includes/footer.inc.php"?>
</body>
</html>