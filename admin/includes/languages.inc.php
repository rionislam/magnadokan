<?php
@session_start();
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$application = new App\Application;
$application->checkAdminLogin();
$language = new App\Language;
?>
<header>
    <div class="left">
        <div class="title">Languages</div>
    </div>
    <div class="right">
        <form class="search-bar" action="" method="post">
            <input type="text" id="search" name="search" placeholder="Search here...">
            <input type="image" src="<?=App\Application::$HOST?>/imgs/search.svg">
        </form>
        <button id="addNewBtn" onclick="addNew('language')">Add New</button>
    </div>
   
</header>
<hr>
<section class="language-container">
    <div class="row header-row">
        <div class="name">Name</div>
        <div class="details">Details</div>
    </div>
    <hr>
    <div class="rows-container">
        <?php $language->load()?>
    </div>
</section>