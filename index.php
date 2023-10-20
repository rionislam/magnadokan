<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
@session_start();
use App\Application;
$application = new Application;
$category = new App\Category;
$book = new App\Book;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="var(--accent-1)" />
    <title>Magna Dokan</title>
    <meta name="description" content="We provide free pdf version of books to those people who can't affort to buy the original copy of the books. You can 
                pdf of any book from our website for free. Although we always suggest to buy the real copy of the book.
                We do it all for educational purpous only. We also promote the original copy of the books we provide through our
                website. Most of the writters and pubblisher don't mind if their books are distributed to the underprivileged people
                for free. If anyone mind and don't want their content to be distributed for free they can place a request and we will 
                remove their content according to the DMCA policy.">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=Application::$HOST?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=Application::$HOST?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=Application::$HOST?>/favicon-16x16.png">
    <link rel="manifest" href="<?=Application::$HOST?>/menifest.json">
    <link rel="stylesheet" href="css/swiper.min.css">
    <link rel="stylesheet" href="<?=Application::$HOST?>/css/global.css">
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
    <?php echo $application->showError()?>
    <?php include "includes/login-signup.inc.php"?>
    <main>
        <section class="navigation">
            <div class="navigation-container max-width center">
                <header><a href="#home"><h1>Magna Do<span class="accent-1">kan.</span></h1></a></header>
                <img id="menuBtn" src="imgs/menu.svg" onclick="showMenu(this)" alt="Mobile Menu Button">
                <nav class="landscape">
                    <ul>
                        <li><a href="#popular-categories">Popular Catagories</a></li>
                        <li><a href="#english-books">English Books</a></li>
                        <li><a href="#bangla-books">Bangla Books</a></li>
                        <li>
                            <form class="search-bar" action="<?=Application::$HOST?>/controllers/search.controller.php" method="post">
                            <input type="text" name="search" placeholder="Search here...">
                            <input type="image" src="imgs/search.svg" alt="Search Button">
                            </form></li>
                        <li><?=($application->checkUserLogin()) ? '<img src="imgs/account_circle.svg">':'<button class="loginBtn" onclick="showLoginSignup()">Login</button>'?></li>
                    </ul>
                </nav>
                <nav class="vertical">
                    <ul>
                        <li><?=($application->checkUserLogin()) ? '<img src="imgs/account_circle.svg">':'<button class="loginBtn" onclick="showLoginSignup()">Login</button>'?></li>
                        <li>
                            <form class="search-bar" action="<?=Application::$HOST?>/controllers/search.controller.php" method="post">
                            <input type="text" name="search" placeholder="Search here..." alt="Search Input">
                            <input type="image" src="imgs/search.svg" alt="Search Button">
                            </form>
                        </li>
                        <li onclick="showMenu(menuBtn)">
                            <a href="#popular-categories">Popular Catagories</a>
                        </li>
                        <li onclick="showMenu(menuBtn)">
                            <a href="#english-books">English Books</a>
                        </li>
                        <li onclick="showMenu(menuBtn)">
                            <a href="#bangla-books">Bangla Books</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
        <section id="home" class="home max-width center">
            <div class="left">
                <h2>Welcome!</h2>
                <p>Here you will get all type of books for free.</p>
                <div><a href="<?=Application::$HOST?>/book-request"  target="_blank" <?=(isset($_SESSION['userId']))?'':'onclick="showLoginSignup(); event.preventDefault();"';?> >Request a book...</a></div>
            </div>
            <div class="right">
                <img src="imgs/books.png">
            </div>
        </section>
        <section id="popular-categories" class="popular-categories max-width center">
            <div class="title">Popular Catagories</div>
            <div class="articles-container">
                <?=$category->loadPopularList()?>
            </div>
        </section>
        <section id="english-books" class="english-books max-width center">
            <div class="title">English Books</div>
            <div class="books-container swiper">
                <div class="books-wrapper swiper-wrapper">
                    <?php
                    $book->loadPopularByLanguage(8, 'English'); 
                    ?>
                    <article class="swiper-slide" id="showMore">
                        <a href="<?=Application::$HOST?>/books/language=English">
                            <img src="imgs/arrow_circle_right.svg" alt="More English Books">
                            <h3 class="name">Show More</h3>
                        </a>
                    </article>
                </div>
            </div>
        </section>
        <section id="bangla-books" class="bangla-books max-width center">
            <div class="title">Bangla Books</div>
            <div class="books-container swiper">
                <div class="books-wrapper swiper-wrapper">
                    <?php
                    $book->loadPopularByLanguage(8, 'Bangla');
                    ?>
                    <article class="swiper-slide" id="showMore">
                        <a href="<?=Application::$HOST?>/books/language=Bangla">
                            <img src="imgs/arrow_circle_right.svg" alt="More Bangla Books">
                            <h3 class="name">Show More</h3>
                        </a>
                    </article>
                </div>
            </div>
        </section>
    </main>
    <?php include 'includes/footer.inc.php'?>
    <script src="js/swiper.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
