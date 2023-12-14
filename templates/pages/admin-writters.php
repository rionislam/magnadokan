<?php
// define the pagename for selecting the active nav bar
define('pageName', 'admin-writters');
use Core\Application;
use Core\Controllers\AdminWritterController;
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateAdminHead('Writters', pageName)?>
</head>
<body>
<?=ResourceLoader::loadComponent('admin-nav')?>
<main>
<header>
    <div class="left">
        <div class="title">Writters</div>
    </div>
    <div class="right">
        <form class="search-bar" action="" method="post">
            <input type="text" id="search" name="search" placeholder="Search here...">
            <input type="image" src="<?=Application::$HOST?>/assets/images/icons/search.svg">
        </form>
        <button id="addNewBtn" onclick="addNew('writter')">Add New</button>
    </div>
   
</header>
<hr>
<section class="writter-container">
    <div class="row header-row">
        <div class="icon">Icon</div>
        <div class="name">Name</div>
        <div class="details">Details</div>
    </div>
    <hr>
    <div class="rows-container">
        <?php
        $adminWritterController = new AdminWritterController;
        $adminWritterController->loadAll();
        ?>
    </div>
</section>
</main>
</body>
</html>