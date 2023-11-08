<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
@session_start();
$drive = new App\Drive;
$application = new App\Application;
$application->checkAdminLogin();
$book = new App\Book;

if(isset($_SESSION['file_name'])){
    $pdf_temp_location = $_SESSION['file_name'];
    $pdf_name = str_replace(" ","-", $_SESSION['book_name']).".pdf";
    $pdf_id = $drive->upload_file($pdf_name, $pdf_temp_location);

    if($book->setPdf($_SESSION['book_id'], $pdf_id)){
        unset($_SESSION['book_id']);
        unset($_SESSION['book_name']);
        unset($_SESSION['file_name']);
        header("Location: ".App\Application::$HOST."/admin/p/books");
    }
    exit();
}

$id = $_POST['id'];
$name = $_POST['name'];
$buyingLink = $_POST['buyingLink'];
$language = $_POST['language'];
$writters = $_POST['writters'];
$description = $_POST['description'];
$tags = $_POST['tags'];
$category = $_POST['category'];
if(empty($name) || empty($language) || empty($writters) || empty($description) || empty($tags) || empty($category)){
    header("Location: ".App\Application::$HOST);
    exit();
}

if(!$book->update($id, $name, $buyingLink, $language, $writters, $category, $description, $tags)){
    exit();
}

if(isset($_POST['cover'])){
    $book->setCover($id, $_POST['cover']);
}


if(isset($_FILES['pdf']) && $_FILES['pdf']['size'] > 0){
    $_SESSION['book_id'] = $id;
    $_SESSION['book_name'] = $name;
    $_SESSION['redirection_target'] = 'add-book';

    // SECTION - Upload the pdf to google drive
    $pdf = $_FILES['pdf'];
    $pdf_temp_location = $pdf['tmp_name'];
    $pdf_name = str_replace(" ","-", $name).".pdf";
    $pdf_id = $drive->upload_file($pdf_name, $pdf_temp_location);

    if($book->setPdf($id, $pdf_id)){
        unset($_SESSION['book_id']);
        unset($_SESSION['book_name']);
        unset($_SESSION['redirection_target']);
        
    }
}else if(isset($_POST['pdf_id']) && !empty($_POST['pdf_id'])){
    $book->setPdf($id, $_POST['pdf_id']);
}

header("Location: ".App\Application::$HOST."/admin/p/book-details/".$id);



