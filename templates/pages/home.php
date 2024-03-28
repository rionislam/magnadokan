<?php
define('pageName', 'home');
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

use Core\Controllers\BookController;
use Core\Controllers\CategoryController;
use Core\Application;
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags(), pageName)?>
    <?=ResourceLoader::loadUtilityCss('slider')?>
    
</head>
<body>
    <!-- Show if there is any user notification -->
    <?=ResourceLoader::loadNotification()?>

    <!-- Load the fixed login-signup form -->
    <?=ResourceLoader::loadComponent('login-signup')?>

    <!-- Load the downloads left -->
    <?=ResourceLoader::loadComponent('downloads-left')?>
    <main>
        <!-- Load the header -->
        <?=ResourceLoader::loadComponent('header')?>

        <!-- main serction of the home -->
        <section id="home" class="home max-width center">
            <div class="left">
                <h2>Welcome!</h2>
                <p>Here you will get all type of books for free.</p>
                <div><a href="<?=Application::$HOST?>/book-request"  target="_blank" <?=(isset($_SESSION['USER_ID']))?'':'onclick="event.preventDefault(); showLoginSignup();"';?> >Request a book...</a></div>
            </div>
            <div class="right">
                <div class="img"></div>
            </div>
        </section>

        <!-- Popular categories -->
        <section id="popular-categories" class="popular-categories max-width center">
            <div class="title">Popular Catagories</div>
            <div class="articles-container">
                <?php
                $categoryController = new CategoryController;
                $categoryController->loadPopularList();
                ?>
            </div>
        </section>

        <!-- Popular english books of last 7 days -->
        <section id="english-books" class="english-books max-width center">
            <div class="title">English Books</div>
            <div class="books-container slider">
                <div class="books-wrapper slider-wrapper">
                    <?php
                    $bookController = new BookController;
                    $bookController->loadPopularByLanguage(8, 'English');
                    ?>
                    <article class="slide" id="showMore">
                        <a href="<?=Application::$HOST?>/books/language/English/1">
                            <img style="opacity: 1;" src="assets/images/icons/arrow_circle_right.svg" alt="More English Books">
                            <h3 class="name">Show More</h3>
                        </a>
                    </article>
                </div>
            </div>
        </section>

        <!-- Popular bangla books of last 7 days -->
        <section id="bangla-books" class="bangla-books max-width center">
            <div class="title">Bangla Books</div>
            <div class="books-container slider">
                <div class="books-wrapper slider-wrapper">
                    <?php
                    $bookController->loadPopularByLanguage(8, 'Bangla');
                    ?>
                    <article class="slide" id="showMore">
                        <a href="<?=Application::$HOST?>/books/language/Bangla/1">
                            <img style="opacity: 1;" src="assets/images/icons/arrow_circle_right.svg" alt="More Bangla Books">
                            <h3 class="name">Show More</h3>
                        </a>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <!-- Load the footer -->
    <?=ResourceLoader::loadComponent('footer')?>

    <!-- The javascript for the slider -->
    <?=ResourceLoader::loadUtilityJS('slider')?>

    <!-- The default javascript -->
    <?=ResourceLoader::loadAppJs()?>

    <!-- Load gtag for google services intrigration -->
    <?=ResourceLoader::loadGtag()?>
    <!-- Schema Data -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "WebSite",
            "name": "Magna Dokan",
            "alternateName" : "magnadokan",
            "url": "https://magnadokan.com",
            "potentialAction": {
            "@type": "SearchAction",
            "target": {
            "@type": "EntryPoint",
            "urlTemplate": "https://magnadokan.com/search/{search_term_string}/1"
            },
            "query-input": "required name=search_term_string"
            }
        }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Magna Dokan",
      "url": "https://magnadokan.com",
      "logo": "https://magnadokan.com/android-chrome-512x512.png"
    }
    </script>
    
</body>
</html>
