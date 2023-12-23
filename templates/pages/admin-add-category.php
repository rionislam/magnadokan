<?php
define('pageName', 'admin-categories');
use Core\Application;
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
    <?=HtmlGenerator::generateAdminHead('Add Category', pageName)?>
</head>
<body>
<?=ResourceLoader::loadNotification()?>
<?=ResourceLoader::loadComponent('admin-nav')?>
<main>
<header>
    <div class="left">
        <div class="title">Add new Category</div>
    </div>
    <div class="right">
        <button id="back" onclick="back('categories')">Back<?=ResourceLoader::loadIcon('back.svg')?></button>
        <button id="save" onclick="addCategory()">Save</button>
    </div>
</header>
<hr>
<section class="form-container">
    <form action="<?=Application::$HOST?>/admin/process-add-category" method="post" enctype="multipart/form-data">
        <div class="input-container icon">
            <div class="input-name">Icon</div>
            <div class="input-wrapper" id="icon_img">
                <input type="file" id="icon"  accept=".jpg, .jpeg, .png" required>
                <div class="label">Select icon image</div>
            </div>
        </div>
        <div class="input-container category">
            <div class="input-name">Category Name</div>
            <input type="text" name="category" id="category" required>
        </div>
    </form>
</section>
</main>
<?=ResourceLoader::loadPageJs('admin-categories')?>
</body>
</html>