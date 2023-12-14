<?php
namespace Core\Services;

use Core\Models\Session;

class SessionService extends Session{

    public function init(){
        if(isset($_COOKIE['SESSION_ID'])){
            $this->validate();
        }
    }

    public function start($userId, $userName, $remember){
        $_SESSION['USER_ID'] = $userId;
        $_SESSION['USER_NAME'] = $userName;
        if($remember){
            $this->create($userId, $userName);
        }
    }

    public function destroy(){
        if($this->changeStatus($_COOKIE['SESSION_ID'], 'loggedOut')){
            unset($_SESSION['USER_ID']);
            unset($_SESSION['USER_NAME']);
            unset($_COOKIE['SESSION_ID']);
            setcookie('SESSION_ID', '', 0, '/');
            return true;
        }else{
            return false;
        }
        
    }

    public static function isLoggedIn(){
        if(isset($_SESSION['USER_ID']) && isset($_SESSION['USER_NAME'])){
            return true;
        }else{
            return false;
        }
    }

}