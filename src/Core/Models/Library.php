<?php
namespace Core\Models;

use Core\Application;
use Core\Services\ResourceLoader;

class Library extends Dbh{
    public function check($bookId){
        if(isset($_SESSION['USER_ID'])){
            return $this->rowExists("library", "`bookId`={$bookId} and `userId` = {$_SESSION['USER_ID']}");
        }
        return false;
        
    }

    protected function add($bookId, $userId){
        if(!$this->check($bookId)){
            $response = $this->createRow('library', ['bookId', 'userId'], 'ii', $bookId, $userId);
            if($response != false){
                //TODO - need to change the secure to true
                setcookie('LIBRARY_ADDED', 1, time()+365*24*3600, $_SERVER['REQUEST_URI'], $_SERVER['HTTP_HOST'], false, true);
                return true;
            }else{
                return false;
            }
        }else{
            if(!isset($_COOKIE['LIBRARY_ADDED'])){
                //TODO - need to change the secure to true
                setcookie('LIBRARY_ADDED', 1, time()+365*24*3600, '/', $_SERVER['HTTP_HOST'], false, true);
            }
            return false;
        }
        
    }

    public function remove($libraryId){
        $response = $this->deleteRow('library', 'libraryId', $libraryId);
         if($response != false){
            return true;
         }else{
            return false;
         }
    }

    public function get(){
        $sql = "SELECT * FROM `library` WHERE `userId`='{$_SESSION['USER_ID']}';";
        $rows = $this->getRows($sql);
        return $rows;
    }
}