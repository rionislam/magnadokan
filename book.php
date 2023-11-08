<?php

@session_start();
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
new App\Application;
$book = new App\Book;
$row = $book->getByName($_GET['name']);
$book->click($row['bookId'], $row['bookCategory']);
$category = new App\Category;
$category->click($row['bookCategory']);
$log = new App\Log;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="var(--accent-1)" />
    <meta property="og:title" content="<?=$row['bookName']?>">
    <meta property="og:description" content='<?=str_replace("'","", $row['bookDescription'])?>'>
    <meta property="og:image" content="<?=App\Application::$HOST?>/uploads/<?=$row['bookCover']?>">
    <title><?=$row['bookName']?> | Magna Dokan</title>
    <meta name="description" content='Download <?=$row['bookName']?> pdf for free from magnadokan written by <?=$row['bookWritters']?>. <?=str_replace("'","", $row['bookDescription'])?>'>
    <meta name="keywords" content="<?=$row['bookTags']?>">
   <link rel="apple-touch-icon" sizes="180x180" href="<?=App\Application::$HOST?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=App\Application::$HOST?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=App\Application::$HOST?>/favicon-16x16.png">
    <link rel="manifest" href="<?=App\Application::$HOST?>/menifest.json">
    <base href="<?=App\Application::$HOST?>/"/>
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
        <?php include 'includes/header.inc.php'?>
        <section class="book-container max-width center">
            <div class="left">
                <img src="<?=App\Application::$HOST?>/uploads/<?=$row['bookCover']?>" alt="<?=$row['bookName']?>">
            </div>
            <div class="right">
                <h1 class="title"><?=$row['bookName']?></h1>
                <div class="writters">
                    <h2 class="title">Writters:</h2>
                    <ul>
                        <?php
                        $writters = $row['bookWritters'];
                        $writters = explode(',', $writters);
                        foreach($writters as $writter){
                            echo "<li><a href='#'>{$writter}</a></li>";
                        }
                        ?>
                        
                    </ul>
                </div>
                <div class="bottom">
                    <p class="notice">Note: We always suggest to buy the real copy of the book. This patform is just for them who can't affort to buy.</p>
                    <button class="buy-btn" data-link="<?=$row['bookBuyingLink']?>" onclick="buy(this)"><?php @include "imgs/buy.svg";?>Buy this book.</button>
                    <button class="download-btn" onclick="download(this, <?=(isset($_SESSION['userId'])) ? $_SESSION['userId'] : '0'?>)" data-file="<?=$row['bookPdf']?>"><?php @include "imgs/download.svg";?><span>Download for free.</span></button>
                </div>
                
            </div>
            <div class="bottom">
                <div class="description-container">
                    <h1 class="title">Description</h1>
                    <hr>
                    <p><?=$row['bookDescription']?></p>
                </div>
                <div class="tags-container">
                    <h1 class="title">Tags</h1>
                    <hr>
                    <p><?=$row['bookTags']?></p>
                </div>
            </div>
        </section>
    </main>
    
    <?php include 'includes/footer.inc.php'?>
    <script src="js/script.js"></script>
</body>
</html>