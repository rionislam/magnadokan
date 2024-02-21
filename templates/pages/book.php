<?php
define('pageName', 'book');

use Core\Application;
use Core\Services\ResourceLoader;
use Core\Controllers\BookController;
use Core\Services\HtmlGenerator;


$bookController = new BookController;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateHead($bookController->getSeoTags($name), pageName)?>
    <link rel="canonical" href="<?=Application::$HOST.'/book/'.$name?>"/>
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
        <?=$bookController->loadByName($name)?>
       
    </main>
    
    <!-- Load the footer -->
    <?=ResourceLoader::loadComponent('footer')?>
    <!-- The default javascript -->
    <?=ResourceLoader::loadAppJs()?>
    <!-- Javascript for specific page -->
    <?=ResourceLoader::loadPageJs('book')?>
</body>
</html>