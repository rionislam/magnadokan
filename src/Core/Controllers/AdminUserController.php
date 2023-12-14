<?php
namespace Core\Controllers;

use Core\Models\User;
use Core\Services\AdminAuthHandler;
use Core\Services\ErrorHandler;
use Core\Services\ResourceLoader;

class AdminUserController extends User{
    public function loadAll(){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $rows = $this->getAll();
        if($rows !== false){
            foreach($rows as $row){
                echo "<div class='row''>
                        <div class='user-name'>".$row['userName']."</div>
                        <div class='user-full-name'>".$row['userFullName']."</div>
                        <div class='user-email'>".$row['userEmail']."</div>
                        <div class='user-status'>".$row['userStatus']."</div>
                    </div>";
            }
        }else{
            echo 'Nothing found!';
        }
    }
}