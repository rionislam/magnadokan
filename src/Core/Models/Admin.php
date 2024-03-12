<?php
namespace Core\Models;

use Core\Services\AdminAuthHandler;

class Admin extends Dbh{


    private function check($adminUsername, $adminEmail){
        $sql = "SELECT * FROM `admins` WHERE adminUsername = ? OR adminEmail = ? ;";
        $row = $this->executeQuery($sql, [$adminUsername, $adminEmail]);
        if($row != false){
            return $row[0];
        }
        else{
            return false;
        }
    }

    public function login($adminLogin, $adminPassword, $remember){
        $check = $this->check($adminLogin, $adminLogin);
    
        if ($check == false){
            return false;
            exit();
        }
        $passwordHashed = $check['adminPassword'];
        $checkPassword = password_verify($adminPassword, $passwordHashed);
    
        if($checkPassword == false){
            return false;
            exit();
        }
        else if($checkPassword == true){
            AdminAuthHandler::createSession($check['adminId'], $check['adminUsername'], $remember);
            return true;
            exit();
        }
    
    }
}
    