<?php
namespace Core\Controllers;
use Core\Application;
use Core\Services\ErrorHandler;
use Core\Services\SessionService;

class PageController{
    public function loadHome(){
        include Application::$ROOT_DIR.'/templates/pages/home.php';
    }

    public function loadAbout(){
        include Application::$ROOT_DIR.'/templates/pages/about.php';
    }

    public function loadLogin(){
        include Application::$ROOT_DIR.'/templates/pages/login.php';
    }

    public function loadSignup(){
        include Application::$ROOT_DIR.'/templates/pages/signup.php';
    }

    public function loadBookRequest(){
        include Application::$ROOT_DIR.'/templates/pages/book-request.php';
    }

    public function loadDisclaimer(){
        include Application::$ROOT_DIR.'/templates/pages/disclaimer.php';
    }

    public function loadPrivacyPolicy(){
        include Application::$ROOT_DIR.'/templates/pages/privacy-policy.php';
    }

    public function loadDmca(){
        include Application::$ROOT_DIR.'/templates/pages/dmca.php';
    }

    public function loadFairuse(){
        include Application::$ROOT_DIR.'/templates/pages/fairuse.php';
    }
    
    public function loadLibrary(){
        if(SessionService::isLoggedIn()){
            include Application::$ROOT_DIR.'/templates/pages/library.php';
        }else{
            ErrorHandler::displayErrorPage(403);
        }
        
    }

    public function loadBook($name){
        include Application::$ROOT_DIR.'/templates/pages/book.php';
    }

    public function downloadBook($name){
        if($_COOKIE['DOWNLOADS_LEFT'] > 0 || SessionService::isLoggedIn()){
            include Application::$ROOT_DIR.'/templates/pages/download.php';
        }else{
            ErrorHandler::displayErrorPage(403);
        }
    }

    public function loadBooksByCategory($category, $page){
        $title = $category." Books";
        include Application::$ROOT_DIR.'/templates/pages/books.php';
    }

    public function loadBooksByKeyword($keyword, $page){
        $title = "Search result for ".$keyword;
        include Application::$ROOT_DIR.'/templates/pages/books.php';
    }

    public function loadBooksByLanguage($language, $page){
        $title =  $language." Books";
        include Application::$ROOT_DIR.'/templates/pages/books.php';
    }

    public function loadAllBooks($page){
        $title = "All Books";
        include Application::$ROOT_DIR.'/templates/pages/books.php';
    }
}