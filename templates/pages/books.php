<?php
use Core\Services\ResourceLoader;
use Core\Controllers\BookController;
use Core\Services\HtmlGenerator;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags($title), 'books')?>
</head>
<body>
        <!-- Load gtag for google services intrigration -->
        <?=ResourceLoader::loadGtag()?>
        
        <!-- Show if there is any user notification -->
        <?=ResourceLoader::loadNotification()?>

        <!-- Load the fixed login-signup form -->
        <?=ResourceLoader::loadComponent('login-signup')?>

        <!-- Load the downloads left -->
        <?=ResourceLoader::loadComponent('downloads-left')?>
    <main>
        <!-- Load the header -->
        <?=ResourceLoader::loadComponent('header')?>
        <?php
        $bookController = new BookController;
        if(isset($category)){
           echo $bookController->loadByCategory($category, $page);
        }
        if(isset($keyword)){
            echo $bookController->loadByKeyword($keyword, $page);
        }
        if(isset($language)){
            echo $bookController->loadByLanguage($language, $page);
        }
        if(!isset($category) && !isset($keyword) && !isset($language)){
            echo $bookController->loadAll($page);
        }
        ?>
    </main>
        <!-- Load the footer -->
        <?=ResourceLoader::loadComponent('footer')?>

        <?=ResourceLoader::loadPageJs('books')?>
</body>
</html>