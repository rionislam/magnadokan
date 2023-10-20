<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
@session_start();
$application = new App\Application;
$application->checkUserLogin();
$book = new App\Book;

$name = $_POST['bookName'];
$writters = $_POST['bookWritters'];
$publication = $_POST['publication'];
$note = $_POST['note'];

if($book->request($_SESSION['userId'], $name, $writters, $publication, $note) !== false){
    header("Location: ".App\Application::$HOST);
};
