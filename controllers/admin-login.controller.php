<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

$adminLogin = $_POST['admin-login'];
$adminPassword = $_POST['admin-password'];
$admin = new App\Admin;
if($admin->login($adminLogin, $adminPassword)){
    if(isset($_POST['remember_login'])){
        // $admin->set_cookie($adminLogin, $adminPassword);
    }
    header('Location: ../admin');
}else{
    header('Location: ../admin/login/wronglogin');
}