<?php
spl_autoload_register('myAutoloader');

function myAutoloader($className){
    $path = $_SERVER['DOCUMENT_ROOT'].'/apis/';
    $extention = '.api.php';
    $full_path = $path.lcfirst($className).$extention;
    require_once($full_path);

}