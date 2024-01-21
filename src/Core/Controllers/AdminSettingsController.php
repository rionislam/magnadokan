<?php
namespace Core\Controllers;

use Core\Services\ConfigEditor;

class AdminSettingsController{
    public function saveSettings(){
        $title = (isset($_POST['title'])?$_POST['title']:TITLE);
        $description = (isset($_POST['description'])?htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8'):DESCRIPTION);
        $gtags = (isset($_POST['gtags'])?htmlspecialchars($_POST['gtags'], ENT_QUOTES, 'UTF-8'):GTAG);
        $configEditor = new ConfigEditor;
        if($configEditor->editApplicationConfig($title, $description, $gtags)){
            $_SESSION['NOTIFICATION'] = true;
            $_SESSION['NOTIFICATION_MESSAGE'] = "Settings are successfully saved.";
        }else{
            $_SESSION['ERROR'] = true;
            $_SESSION['ERROR_MESSAGE'] = "There was an error. Please try again later!";
        }
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
}