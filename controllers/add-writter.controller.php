<?php

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
@session_start();
$application = new App\Application;
$application->checkAdminLogin();

$name = $_POST['writter-name'];
$file = $_FILES['file'];

if(empty($name) || empty($file)){
    header("Location: ".App\Application::$HOST);
    exit;
}

$writter = new App\Writter;
if($writter->add($name, $file)){
    header("Location: ".App\Application::$HOST."/admin/p/writters");
};