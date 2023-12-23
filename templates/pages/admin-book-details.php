<?php
// define the pagename for selecting the active nav bar
define('pageName', 'admin-books');
use Core\Application;
use Core\Controllers\AdminBookController;
use Core\Services\AdminAuthHandler;
use Core\Services\ErrorHandler;
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
if(!AdminAuthHandler::isLoggedIn()){
    ErrorHandler::displayErrorPage(403);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateAdminHead('Books Details', pageName)?>
</head>
<body>
<?=ResourceLoader::loadNotification()?>
<?=ResourceLoader::loadComponent('admin-nav')?>
<main>
<header>
    <div class="left">
        <div class="title">Book Details</div>
    </div>
    <div class="right">
        <button id="back" onclick="back('books')">Back<?=ResourceLoader::loadIcon('back.svg')?></button>
        <button id="update" onclick="updateBook()">Update</button>
    </div>
</header>
<hr>
<section class="form-container">
    <form action="<?=Application::$HOST?>/admin/process-update-book" method="post" enctype="multipart/form-data">
    <?php
    $adminBookController = new AdminBookController;
    echo $adminBookController->showBookDetails($id);
    
    ?>
    </form>
</section>
</main>
<?=ResourceLoader::loadPageJs(pageName)?>
</body>
</html>
