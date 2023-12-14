<?php
namespace Core\Services;

use Core\Application;

class ConfigEditor{
    public function editApplicationConfig($title = NULL, $description = NULL, $gtags = NULL){
        $sample = file_get_contents(Application::$ROOT_DIR."/config/application-sample.php");
        $configFile = fopen(Application::$ROOT_DIR."/config/application.php", 'w');
        $sample = str_replace('{SITE TITLE}', $title, $sample);
        $sample = str_replace('{SITE DESCRIPTION}', $description, $sample);
        $sample = str_replace('{SITE GTAGS}', $gtags, $sample);
        if(fwrite($configFile, $sample)){
            fclose($configFile);
            return true;
        }else{
            fclose($configFile);
            return false;
        }
        
    }
}