<?php
namespace Core;

use Core\Services\ErrorHandler;

class Application{
    public static string $ROOT_DIR;
    public static string $HOST;

    public function __construct(){   
        self::$ROOT_DIR = $_SERVER['DOCUMENT_ROOT'];
        self::$HOST =(!empty($_SERVER['HTTPS']))? "https://".$_SERVER['HTTP_HOST']:"http://".$_SERVER['HTTP_HOST'];
        date_default_timezone_set("UTC");
        require_once(self::$ROOT_DIR.'/config/application.php');
        ErrorHandler::init();
    }
    

}