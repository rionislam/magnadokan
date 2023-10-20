<?php

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
new App\Application;
$user = new App\User;
$userFullName = $_POST['full-name'];
$userUsername = $_POST['username'];
$userEmail = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm-password'];

if(empty($userFullName) || empty($password) || empty($userUsername) || empty($userEmail) || $password !== $confirmPassword){
    exit;
}

$resposne = $user->signup($userFullName, $userUsername, $userEmail, $password);
if($resposne !== true){
    header("Location: ".App\Application::$HOST."/signup/".$resposne);
}else{
    if(strpos($_SERVER['HTTP_REFERER'], "login") !== false){
        header("Location: ".App\Application::$HOST."/login");
    }else{
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
}


