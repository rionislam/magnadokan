<?php
namespace App;

class Application{
    public static string $ROOT_DIR;
    public static string $HOST;

    public function __construct(){   
        self::$ROOT_DIR = $_SERVER['DOCUMENT_ROOT'];
        self::$HOST =(!empty($_SERVER['HTTPS']))? "https://".$_SERVER['HTTP_HOST']:"http://".$_SERVER['HTTP_HOST'];

    }

    public function checkAdminLogin(){
        if(!isset($_SESSION['adminId'])){
            header("Location: ".self::$HOST."/admin/login");
            exit();
        }
    }

    public function checkUserLogin(){
        if(!isset($_SESSION['userId'])){
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

    public function showError(){
        if(isset($_SESSION['error'])){
            $error = $_SESSION['error'];
            $imgSrc = self::$HOST."/imgs/close.svg";
            unset($_SESSION['error']);
            return '<section id="message">
                    <div class="message-wrapper max-width center">
                        <div id="message-container">'.$error.'<img onclick="hideMessage()" src="'.$imgSrc.'"></div>
                    </div>
                    </section>
                    <script>
                        window.addEventListener("load", ()=>{
                            showMessage();
                        })
                    </script>';
        }
    }

}