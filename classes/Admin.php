<?php
namespace App;

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
            header('Location: ../signup.php?error=stmtfailed');
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

    public function login($adminLogin, $adminPassword){
        $check = $this->check($adminLogin, $adminLogin);
    
        if ($check == false){
            header('Location: ../admin/login.php?error=wronglogin');
            return false;
            exit();
        }
        $passwordHashed = $check['adminPassword'];
        $checkPassword = password_verify($adminPassword, $passwordHashed);
    
        if($checkPassword == false){
            header('Location: ../admin/login.php?error=wronglogin');
            return false;
            exit();
        }
        else if($checkPassword == true){
            @@session_start();
            $_SESSION['adminId'] = $check['adminId'];
            $_SESSION['adminUsername'] = $check['adminUsername'];
            header('Location: ../admin');
            return true;
            exit();
        }
    
    }

    public function set_cookie($adminLogin, $adminPassword){
        setcookie('adminLogin', $adminLogin, time() + 31104000, '/');
        setcookie('adminPassword', $adminPassword, time() + 31104000, '/');
    }
        
}
