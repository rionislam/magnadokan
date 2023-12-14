<?php
namespace Core\Controllers;
use Core\Application;
use Core\Models\User;
use Core\Services\Mailer;
use Core\Services\SessionService;

class UserController extends User{
    public function processSignup(){
        $userFullName = $_POST['full-name'];
        $userName = $_POST['username'];
        $userEmail = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];

        if(empty($userFullName) || empty($password) || empty($userName) || empty($userEmail) || $password !== $confirmPassword){
            exit;
        }

        $resposne = $this->signup($userFullName, $userName, $userEmail, $password);
        if($resposne !== true){
            $_SESSION['ERROR'] = true;
            if($resposne == 'username_email_exists'){
                $_SESSION['ERROR_MESSAGE'] = "There is already an account with this email and username!";
            }else if($resposne == 'username_exists'){
                 $_SESSION['ERROR_MESSAGE'] = "Username already exists! Please try another one.";
            }else if($resposne == 'email_exists'){
                 $_SESSION['ERROR_MESSAGE'] = "There is already an account with this email!";
            }
            
            header("Location: {$_SERVER['HTTP_REFERER']}");
        }else{
            $mailer = new Mailer;
            $mailer->sendSignupMail($userEmail, $userName);
            if(strpos($_SERVER['HTTP_REFERER'], "signup") !== false){
                header("Location: ".Application::$HOST."/login");
            }else{
                header("Location: {$_SERVER['HTTP_REFERER']}");
            }
        }
    }

    public function processLogin(){
        $userLogin = $_POST['user-login'];
        $password = $_POST['password'];
        $remember = isset($_POST['remember-login'])??1;
        if($this->login($userLogin, $password, $remember)){
            if(strpos($_SERVER['HTTP_REFERER'], "login") !== false){
                header("Location: ".Application::$HOST);
            }else{
                header("Location: {$_SERVER['HTTP_REFERER']}");
            }
        }else{
            if(strpos($_SERVER['HTTP_REFERER'], "login") !== false){
                header("Location: ".Application::$HOST."/login/wrong_login&login=".$userLogin);
            }else{
                $_SESSION['ERROR'] = true;
                $_SESSION['ERROR_MESSAGE'] = 'Login or password is wrong!';
                header("Location: {$_SERVER['HTTP_REFERER']}");
            }
            exit();
        };
        
    }

    public function logout(){
            $sessionService = new SessionService;
            if($sessionService->destroy()){
                header("Location: ".Application::$HOST);
            };
    }
}