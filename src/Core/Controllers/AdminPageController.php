<?php
namespace Core\Controllers;

use Core\Application;
use Core\Services\AdminAuthHandler;

class AdminPageController{


    public function loadLogin(){
        include Application::$ROOT_DIR."/templates/pages/admin-login.php";
    }

    public function loadDashboard(){
        if(!AdminAuthHandler::isLoggedIn()){
            header("Location: ".Application::$HOST."/admin/login");
            exit;
        }
        include Application::$ROOT_DIR."/templates/pages/admin-dashboard.php";
    }

    public function loadUsers(){
        if(!AdminAuthHandler::isLoggedIn()){
            header("Location: ".Application::$HOST."/admin/login");
            exit;
        }
        include Application::$ROOT_DIR."/templates/pages/admin-users.php";
    }

    public function loadBooks(){
        if(!AdminAuthHandler::isLoggedIn()){
            header("Location: ".Application::$HOST."/admin/login");
            exit;
        }
        include Application::$ROOT_DIR."/templates/pages/admin-books.php";
    }

    public function loadAddBook(){
        if(!AdminAuthHandler::isLoggedIn()){
            header("Location: ".Application::$HOST."/admin/login");
            exit;
        }
        include Application::$ROOT_DIR."/templates/pages/admin-add-book.php";
    }

    public function loadBookDetails($id){
        if(!AdminAuthHandler::isLoggedIn()){
            header("Location: ".Application::$HOST."/admin/login");
            exit;
        }
        include Application::$ROOT_DIR."/templates/pages/admin-book-details.php";
    }

    public function loadCategories(){
        if(!AdminAuthHandler::isLoggedIn()){
            header("Location: ".Application::$HOST."/admin/login");
            exit;
        }
        include Application::$ROOT_DIR."/templates/pages/admin-categories.php";
    }

    public function loadAddCategory(){
        if(!AdminAuthHandler::isLoggedIn()){
            header("Location: ".Application::$HOST."/admin/login");
            exit;
        }
        include Application::$ROOT_DIR."/templates/pages/admin-add-category.php";
    }

    public function loadWritters(){
        if(!AdminAuthHandler::isLoggedIn()){
            header("Location: ".Application::$HOST."/admin/login");
            exit;
        }
        include Application::$ROOT_DIR."/templates/pages/admin-writters.php";
    }

    public function loadAddWritter(){
        if(!AdminAuthHandler::isLoggedIn()){
            header("Location: ".Application::$HOST."/admin/login");
            exit;
        }
        include Application::$ROOT_DIR."/templates/pages/admin-add-writter.php";
    }

    public function loadSettings(){
        if(!AdminAuthHandler::isLoggedIn()){
            header("Location: ".Application::$HOST."/admin/login");
            exit;
        }
        include Application::$ROOT_DIR."/templates/pages/admin-settings.php";
    }

    
}