<?php
namespace Core\Models;

use Core\Application;
use Core\Services\SessionService;

class User extends Dbh{

    //NOTE - Get the number of users
    public function count($condition = NULL){
        $sql= "SELECT * FROM `users` {$condition};";
        $rows = $this->getRows($sql);
        return count($rows);
    }

    protected function getAll($page = NULL){
        if($page == NULL){
            $rows = $this->selectAll('users');
        }else{
            $starting = 0 + 20 * ($page-1);
            $limit = 20;
            $sql = "SELECT * FROM
                    `users` 
                    LIMIT
                        {$starting},{$limit};";
            $rows = $this->getRows($sql);
        }
        
        return $rows;
    }


    private function check($userName, $userEmail){
        $sql = "SELECT * FROM `users` WHERE userName = ? OR userEmail = ? ;";
        $row = $this->executeQuery($sql, [$userName, $userEmail]);

        if($row != false){
            return $row[0];
        }
        else{
            return false;
        }
    }

    public function logedIn(){
        if(isset($_SESSION['USER_ID'])){
            return true;
        }else{
            return false;
        }
    }

    protected function login($userLogin, $userPassword, $remember){
        $check = $this->check($userLogin, $userLogin);
    
        if ($check == false){
            return false;
            exit();
        }
        $passwordHashed = $check['userPassword'];
        $checkPassword = password_verify($userPassword, $passwordHashed);
    
        if($checkPassword == false){
            return false;
            header("Location: ".Application::$HOST."/login");
            exit();
        }
        else if($checkPassword == true){
            $sessionService = new SessionService;
            $sessionService->start($check['userId'], $check['userName'], $remember);
            return true;
            exit();
        }
    
    }

    public function signup($userFullName, $userName, $userEmail, $userPassword){
        $checkUsername = $this->check($userName, $userName);
        $checkEmail = $this->check($userEmail, $userEmail);
        
        if($checkUsername && $checkEmail){
            return 'username_email_exists';
        }else if($checkUsername){
            return 'username_exists';
            exit();
        }else if($checkEmail){
            return 'email_exists';
            exit();
        }
        
        $passwordHashed = password_hash($userPassword, PASSWORD_DEFAULT);
        $this->createRow('users', ['userFullName', 'userName', 'userPassword', 'userEmail'], 'ssss', $userFullName, $userName, $passwordHashed, $userEmail);
        return true;
    }
}