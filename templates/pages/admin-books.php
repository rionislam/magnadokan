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
    <?=HtmlGenerator::generateAdminHead('Books', pageName)?>
</head>
<body>
<?=ResourceLoader::loadComponent('admin-nav')?>
<main>
<header>
    <div class="left">
        <div class="title">Books</div>
    </div>
    <div class="right">
        <form class="search-bar" action="" method="post">
            <input type="text" id="search" name="search" placeholder="Search here...">
            <input type="image" src="<?=Application::$HOST?>/assets/images/icons/search.svg">
        </form>
        <button id="addNewBtn" onclick="addNew('book')">Add New</button>
    </div>
</header>
<hr>

        <?php
            $AdminBookController = new AdminBookController;
            echo $AdminBookController->loadAll($page);
        ?>
    
</section>
</main>

</body>
</html>