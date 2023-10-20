<?php


require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$fileUniqueId = $_GET['id'];
$file = new File;
$book = new App\Book;
$category = new App\Category;
new App\Application;
@session_start();
if(!isset($_SESSION['userId'])){
    header("Location: ".App\Application::$HOST);
    exit();
}
$row = $file->get($fileUniqueId);
$row1 = $book->get($row['bookName']);
$book->download($row['bookName']);
$category->download($row1['bookCategory']);
$file->download($fileUniqueId);

