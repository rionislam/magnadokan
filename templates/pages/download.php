<?php
define('pageName', 'download');

use Core\Services\ResourceLoader;
use Core\Controllers\BookController;
use Core\Services\ErrorHandler;
use Core\Services\HtmlGenerator;
use Core\Services\SessionService;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';


//TODO - Need to secure the downloading process
if($_COOKIE['DOWNLOADS_LEFT'] == 0 && !SessionService::isLoggedIn()){
    ErrorHandler::displayErrorPage(403);
}
$bookController = new BookController;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags('Download - '. urldecode($name)), pageName, true)?>
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
        <?=$bookController->loadForDownloadPageByName($name)?>
    </main>
    <!-- Load the footer -->
    <?=ResourceLoader::loadComponent('footer')?>

    <!-- Load the page js -->
    <?=ResourceLoader::loadPageJs(pageName)?>

    <!-- The default javascript -->
    <?=ResourceLoader::loadAppJs()?>

    <!-- Load gtag for google services intrigration -->
    <?=ResourceLoader::loadGtag()?>
</body>
</html>
</body>
</html>