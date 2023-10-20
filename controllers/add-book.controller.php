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

$cover = $_POST['cover'];
$pdf = $_FILES['pdf'];
$name = $_POST['name'];
$buyingLink = $_POST['buyingLink'];
$language = $_POST['language'];
$writters = $_POST['writters'];
$description = $_POST['description'];
$tags = $_POST['tags'];
$category = $_POST['category'];
if(empty($cover) || empty($name) || empty($language) || empty($writters) || empty($description) || empty($tags) || empty($category)){
    header("Location: ".App\Application::$HOST);
    exit();
}

$response = $book->add($name, $buyingLink, $language, $writters, $description, $tags, $cover, $category);
if($response == false){
    exit();
}
$_SESSION['book_id'] = $response;
$_SESSION['book_name'] = $name;
$_SESSION['redirection_target'] = 'add-book';

if(isset($_FILES['pdf']) && $_FILES['pdf']['size'] > 0){
    $_SESSION['book_id'] = $response;
    $_SESSION['book_name'] = $name;
    $_SESSION['redirection_target'] = 'add-book';

    // SECTION - Upload the pdf to google drive
    $pdf_temp_location = $_FILES['pdf']['tmp_name'];
    $pdf_name = str_replace(" ","-", $name).".pdf";
    $pdf_id = $drive->upload_file($pdf_name, $pdf_temp_location);

    if($book->setPdf($response, $pdf_id)){
        unset($_SESSION['book_id']);
        unset($_SESSION['book_name']);
        unset($_SESSION['redirection_target']);
        header("Location: ".App\Application::$HOST."/admin/p/books");
    }
}else if(isset($_POST['pdf_id']) && !empty($_POST['pdf_id'])){
    if($book->setPdf($response, $_POST['pdf_id'])){
        header("Location: ".App\Application::$HOST."/admin/p/books");
    }
    
}





