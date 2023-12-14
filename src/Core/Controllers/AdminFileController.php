<?php
namespace Core\Controllers;

use Core\Services\AdminAuthHandler;
use Core\Services\ErrorHandler;
use Core\Services\FileHandler;

class AdminFileController extends FileHandler{
    public function uploadImage(){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $porpous = $_POST['purpous'];
        if($porpous == 'bookCover'){
            $file = $_FILES['file'];
            $response = $this->storeImage($file, 250, 375, 'books/covers/');
            if($response != false){
                $this->add($response, $porpous);
                echo $response;
            }
        }else if($porpous == 'categoryIcon'){
            $file = $_FILES['file'];
            $response = $this->storeImage($file, 250, 375, 'categories/icons/');
            if($response != false){
                $this->add($response, $porpous);
                echo $response;
            }
        }else if($porpous == 'writterImage'){
            $file = $_FILES['file'];
            $response = $this->storeImage($file, 250, 375, 'writters/images/');
            if($response != false){
                $this->add($response, $porpous);
                echo $response;
            }
        }
    }

    
}