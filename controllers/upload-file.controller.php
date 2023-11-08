<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$inputFile = $_FILES['file'];
$allowed = json_decode($_POST['allowed']);
$width = $_POST['width'];
$file = new App\File;
echo $file->upload($inputFile, $allowed, $width);


