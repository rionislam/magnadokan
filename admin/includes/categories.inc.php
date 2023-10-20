<?php
@session_start();
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$application = new App\Application;
$application->checkAdminLogin();
$category = new App\Category;
?>
<header>
    <div class="left">
        <div class="title">Categories</div>
    </div>
    <div class="right">
        <form class="search-bar" action="" method="post">
            <input type="text" id="search" name="search" placeholder="Search here...">
            <input type="image" src="<?=App\Application::$HOST?>/imgs/search.svg">
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
        <?php $category->load()?>
    </div>
</section>