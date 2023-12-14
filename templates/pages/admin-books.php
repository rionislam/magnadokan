<?php
// define the pagename for selecting the active nav bar
define('pageName', 'admin-books');
use Core\Application;
use Core\Controllers\AdminBookController;
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
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
<section class="books-container">
    <div class="row header-row">
        <div class="name">Name</div>
        <div class="writter">Writter</div>
        <div class="downloads">Downloads</div>
        <div class="clicks">Clicks</div>
        <div class="details">Details</div>
    </div>
    <hr>
    <div class="rows-container">
        <?php
        $AdminBookController = new AdminBookController;
        $AdminBookController->loadAll();
        ?>
    </div>
</section>
</main>

</body>
</html>