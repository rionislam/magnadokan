<?php
namespace Core\Models;

use Core\Services\AdminAuthHandler;

class Admin extends Dbh{

    private $dbConn;

    public function __construct()
        {
            $this->dbConn = $this->connect();
        }

        private function check($adminUsername, $adminEmail){
            $sql = "SELECT * FROM `admins` WHERE adminUsername = ? OR adminEmail = ? ;";
            $stmt = $this->dbConn->stmt_init();
            if(!$stmt->prepare($sql))
            {
                return false;
                exit();
            }
        
            $stmt->bind_param('ss', $adminUsername, $adminEmail);
            $stmt->execute();

            $result = $stmt->get_result();

            if($row = $result->fetch_assoc()){
                return $row;
            }
            else{
                return false;
            }
            $stmt->close();
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
    