<?php
namespace Core\Controllers;

use Core\Application;
use Core\Models\Admin;

class AdminController extends Admin{
    public function processLogin(){
        $adminLogin = $_POST['admin-login'];
        $adminPassword = $_POST['admin-password'];
        $remember = isset($_POST['remember-login'])??1;
        if($this->login($adminLogin, $adminPassword, $remember)){
            header("Location: ".Application::$HOST."/admin");
            exit;
        }else{
            $_SESSION['ERROR'] = true;
            $_SESSION['ERROR_MESSAGE'] = 'Login or password is wrong!';
            header("Location: ".Application::$HOST."/admin/login");
        }
    }
}