<?php
namespace App;

class User extends Dbh{

    private $dbConn;

    public function __construct()
    {
        $this->dbConn = $this->connect();
    }


    private function check($userUsername, $userEmail){
        $sql = "SELECT * FROM `users` WHERE userUsername = ? OR userEmail = ? ;";
        $stmt = $this->dbConn->stmt_init();
        if(!$stmt->prepare($sql))
        {
            header('Location: ../signup.php?error=stmtfailed');
            exit();
        }
    
        $stmt->bind_param('ss', $userUsername, $userEmail);
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

    public function logedIn(){
        if(isset($_SESSION['userId'])){
            return true;
        }else{
            return false;
        }
    }

    public function login($userLogin, $userPassword){
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
            @session_start();
            $_SESSION['userId'] = $check['userId'];
            $_SESSION['userUsername'] = $check['userUsername'];
            return true;
            exit();
        }
    
    }

    public function signup($userFullName, $userUsername, $userEmail, $userPassword){
        $checkUsername = $this->check($userUsername, $userUsername);
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
        $this->createRow('users', ['userFullName', 'userUsername', 'userPassword', 'userEmail'], 'ssss', $userFullName, $userUsername, $passwordHashed, $userEmail);
        return true;
    }
}