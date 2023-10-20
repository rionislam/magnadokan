<?php

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
new App\Application;
$user = new App\User;
$userLogin = $_POST['user-login'];
$password = $_POST['password'];

if(empty($userLogin) || empty($password)){
    exit;
}

;

if($user->login($userLogin, $password)){
    if(strpos($_SERVER['HTTP_REFERER'], "login") !== false){
        header("Location: ".App\Application::$HOST);
    }else{
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
    
}else{
    if(strpos($_SERVER['HTTP_REFERER'], "login") !== false){
        header("Location: ".App\Application::$HOST."/login/wrong_login&login=".$userLogin);
    }else{
        session_start();
        $_SESSION['error'] = 'Login or password is wrong!';
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
    exit();
};
