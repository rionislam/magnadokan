<?php
namespace Core\Services;

class AdminAuthHandler{
    public static function isLoggedIn(){
        if(isset($_SESSION['ADMIN_ID']) && isset($_SESSION['ADMIN_USERNAME'])){
            return true;
        }else{
            return false;
        }
    }

    public static function createSession($adminId, $adminUserName, $remember){
        $_SESSION['ADMIN_ID'] = $adminId;
        $_SESSION['ADMIN_USERNAME'] = $adminUserName;
        if($remember){
            //remember login is not supported for admins rightnow
        }
    }



}