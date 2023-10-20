<?php
@session_start();
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$application = new App\Application;
$application->checkAdminLogin();
$book = new App\Book;
?>
<header>
    <div class="left">
        <div class="title">Books</div>
    </div>
    <div class="right">
        <form class="search-bar" action="" method="post">
            <input type="text" id="search" name="search" placeholder="Search here...">
            <input type="image" src="../imgs/search.svg">
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
        <?php $book->load()?>
    </div>
</section>