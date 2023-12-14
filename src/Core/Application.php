<?php
namespace Core;

class Application{
    public static string $ROOT_DIR;
    public static string $HOST;

    public function __construct(){   
        self::$ROOT_DIR = $_SERVER['DOCUMENT_ROOT'];
        self::$HOST =(!empty($_SERVER['HTTPS']))? "https://".$_SERVER['HTTP_HOST']:"http://".$_SERVER['HTTP_HOST'];
        date_default_timezone_set("UTC");
        require_once(self::$ROOT_DIR.'/config/application.php');
        set_error_handler(['Core\Services\ErrorHandler', 'handleErrors']);
        set_exception_handler(['Core\Services\ErrorHandler', 'handleExceptions']);
        register_shutdown_function(['Core\Services\ErrorHandler', 'handleShutdown']);
    }

    public function checkAdminLogin(){
        if(!isset($_SESSION['adminId'])){
            header("Location: ".self::$HOST."/admin/login");
            exit();
        }
    }

    public function checkUserLogin(){
        // $session = new Session;
        // $session->validate();
        if(!isset($_SESSION['USER_ID'])){
            return false;
            exit();
        }
        return true;
        
    }

    public function checkPage(){
        if(isset($_GET['p'])){
            $p = $_GET['p'];
            include "includes/".$p.".inc.php";
        }else{
            include "includes/dashboard.inc.php";
        }
    }
    

}