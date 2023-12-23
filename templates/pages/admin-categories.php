<?php
// define the pagename for selecting the active nav bar
define('pageName', 'admin-categories');
use Core\Application;
use Core\Controllers\AdminCategoryController;
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
    <?=ResourceLoader::loadNotification()?>
<?=ResourceLoader::loadComponent('admin-nav')?>
<main>
<header>
    <div class="left">
        <div class="title">Categories</div>
    </div>
    <div class="right">
        <form class="search-bar" action="" method="post">
            <input type="text" id="search" name="search" placeholder="Search here...">
            <input type="image" src="<?=Application::$HOST?>/assets/images/icons/search.svg">
        </form>
        <button id="addNewBtn" onclick="addNew('category')">Add New</button>
    </div>
</header>
<hr>
<section class="categories-container">
    <div class="row header-row">
        <div class="icon">Icon</div>
        <div class="name">Name</div>
        <div class="details">Details</div>
    </div>
    <hr>
    <div class="row-container">
        <?php
        $adminCategoryController = new AdminCategoryController;
        $adminCategoryController->loadAll();
        ?>
    </div>
</section>
</main>

</body>
</html>