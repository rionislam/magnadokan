<?php
namespace Core\Controllers;

use Core\Application;
use Core\Models\Writter;
use Core\Services\FileHandler;
use Core\Services\ErrorHandler;
use Core\Services\ResourceLoader;
use Core\Services\AdminAuthHandler;


class AdminWritterController extends Writter{
    public function loadAll(){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $rows = $this->getAll();
        if($rows !== false){
            $detailsLogo = ResourceLoader::loadIcon('details.svg');
            foreach($rows as $row){
                echo "<div class='row'><div class='icon'><img src='".Application::$HOST."/uploads/writters/images/".$row['writterImg']."'></div><div class='name'>".$row['writterName']."</div><div class='details'>$detailsLogo</div></div>";
            }
        }else{
            echo 'Nothing found!';
        }
    }

    public function loadAllWrittersName(array $filters = []){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $writters = $this->getAllWrittersName();
        if($filters != []){
            $writters = array_diff($writters, $filters);
        }
        
        $writtersDropdown = "";
        if($writters !== NULL){
            foreach($writters as $writter){
                $writtersDropdown .= "<li onclick='selectWritter(this)'>{$writter}</li>";
            }
        }else{
            $writtersDropdown = "Nothing found!";
        }
        return $writtersDropdown;
    }
    
    public function addWritter(){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $name = $_POST['writterName'];
        $writterImage = $_POST['icon'];
        
        if(empty($name) || empty($writterImage)){
            header("Location: ".Application::$HOST);
            exit();
        }

        if($this->add($name, $writterImage)){
            $_SESSION['NOTIFICATION'] = true;
            $_SESSION['NOTIFICATION_MESSAGE'] = "The writter is successfully added.";
            $fileHandler = new FileHandler;
            $fileHandler->use($writterImage);
            header("Location: ".Application::$HOST."/admin/writters");
        }else{
            $_SESSION['ERROR'] = true;
            $_SESSION['ERROR_MESSAGE'] = "There is an error. Please try again later!";
            header("Location: ".Application::$HOST."/admin/add-writter");
        }
    }
}