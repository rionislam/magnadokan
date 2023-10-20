<?php

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
@session_start();
$application = new App\Application;
$application->checkAdminLogin();

$name = $_POST['category'];
$file = $_FILES['icon'];

if(empty($name) || empty($file)){
    header("Location: ".App\Application::$HOST);
    exit;
}
$category = new App\Category;
if($category->add($name, $file)){
    header("Location: ".App\Application::$HOST."/admin/p/categories");
};
