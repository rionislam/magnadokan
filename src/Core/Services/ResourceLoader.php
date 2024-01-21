<?php
namespace Core\Services;

use Core\Application;

class ResourceLoader{
    public static function loadComponent($componentName){
        include Application::$ROOT_DIR."/templates/components/{$componentName}.php";
    }

    public static function loadComponentCss($componentName){
        $url = Application::$HOST."/css/components/{$componentName}.css";
        if(file_exists(Application::$ROOT_DIR."/css/components/{$componentName}.css")){
            return "<link rel='stylesheet' href='{$url}'>";
        }
    }

    

    public static function loadNotification(){
        $body = '<section id="message"></section>
                <script src="'.Application::$HOST.'/js/components/notification.js"></script>
                ';
        if(isset($_SESSION['ERROR']) && $_SESSION['ERROR'] == true){
            $body .= "<script>
                        window.addEventListener('load', ()=>{
                            showMessage('{$_SESSION['ERROR_MESSAGE']}', 'error');
                        })
                    </script>";
            unset($_SESSION['ERROR']);
            unset($_SESSION['ERROR_MESSAGE']);
        }else if(isset($_SESSION['NOTIFICATION']) && $_SESSION['NOTIFICATION'] == true){
            $body .= "<script>
                        window.addEventListener('load', ()=>{
                            showMessage('{$_SESSION['NOTIFICATION_MESSAGE']}', 'notification');
                        })
                    </script>";
            unset($_SESSION['NOTIFICATION']);
            unset($_SESSION['NOTIFICATION_MESSAGE']);
        }

        return $body;
    }

    public static function loadGtag(){
        return htmlspecialchars_decode(GTAG);
    }

    public static function loadIcon($iconName){
        $url = Application::$HOST."/assets/images/icons/{$iconName}";
        if(file_exists(Application::$ROOT_DIR."/assets/images/icons/{$iconName}")){
            $icon = file_get_contents($url);
            return $icon;
        }
       
    }

    public static function loadAppJs(){
        $url = Application::$HOST."/js/app.js";
        if(file_exists(Application::$ROOT_DIR."/js/app.js")){
            return "<script type='module' src='{$url}'></script>";
        }
    }

    public static function loadPageJs($pageName){
        $url = Application::$HOST."/js/pages/{$pageName}.js";
        if(file_exists(Application::$ROOT_DIR."/js/pages/{$pageName}.js")){
            return "<script type='module' src='{$url}'></script>";
        }
        
    }

    public static function loadComponentJs($componentName){
        $url = Application::$HOST."/js/components/{$componentName}.js";
        if(file_exists(Application::$ROOT_DIR."/js/components/{$componentName}.js")){
            return "<script type='module' src='{$url}'></script>";
        }
    }

    public static function loadUtilityCss($utilityName){
        $url = Application::$HOST."/css/utilities/{$utilityName}.css";
        if(file_exists(Application::$ROOT_DIR."/css/utilities/{$utilityName}.css")){
            return "<link rel='stylesheet' href='{$url}'>";
        }
    }

    public static function loadUtilityJS($utilityName){
        $url = Application::$HOST."/js/utilities/{$utilityName}.js";
        if(file_exists(Application::$ROOT_DIR."/js/utilities/{$utilityName}.js")){
            return "<script async src='{$url}'></script>";
        }
    }

}