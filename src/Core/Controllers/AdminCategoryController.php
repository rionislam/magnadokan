<?php
namespace Core\Controllers;

use Core\Application;
use Core\Models\Category;
use Core\Services\FileHandler;
use Core\Services\ErrorHandler;
use Core\Services\ResourceLoader;
use Core\Services\AdminAuthHandler;


class AdminCategoryController extends Category{
    public function loadAll(){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $rows = $this->getAll();
        if($rows !== false){
            $detailsLogo = ResourceLoader::loadIcon('details.svg');
            foreach($rows as $row){
                echo "<div class='row' onclick='this.getElementsByTagName(\"a\")[0].click();'><div class='icon'><img src='".Application::$HOST."/uploads/categories/icons/".$row['categoryIcon']."'></div><div class='name'>".$row['category']."</div><div class='details'>$detailsLogo</div></div>";
            }
        }else{
            echo 'Nothing found!';
        }
    }

    public function loadPopularCategoriesAsArray(){
        $categories = $this->getPopularCategories();
        $totalScore = 0;
        $percentUsed = NULL;
        $result = array();
        foreach($categories as $category){
            $totalScore += intval($category['score']);
        }
        for($i = 0; $i<3; $i++){
            $scoreInPercent = floor(($categories[$i]['score'] / $totalScore)*100);
            
            $result[$categories[$i]['bookCategory']] = $scoreInPercent;
            $percentUsed += $scoreInPercent;
        }

        $result['others'] = 100-$percentUsed;

        return $result;
        
    }

    public function loadAllCategoriesName(string $filter = NULL){
        $categories = $this->getAllCateogoriesNames();
        
        $categoriesDropdown = "";
        if($categories != NULL){
            $categories = array_diff($categories, [$filter]);
            foreach($categories as $category){
                    $categoriesDropdown .= "<li onclick='selectCategory(this)'>{$category}</li>";
            }
        }else{
            $categoriesDropdown = "Nothing found!";
        }

        return $categoriesDropdown;
    }

    public function addCategory(){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $name = $_POST['category'];
        $icon = $_POST['icon'];
        
        if(empty($name) || empty($icon)){
            header("Location: ".Application::$HOST);
            exit();
        }

        if($this->add($name, $icon)){
            $_SESSION['NOTIFICATION'] = true;
            $_SESSION['NOTIFICATION_MESSAGE'] = "The category is successfully added.";
            $fileHandler = new FileHandler;
            $fileHandler->use($icon);
            header("Location: ".Application::$HOST."/admin/categories");
        }else{
            $_SESSION['ERROR'] = true;
            $_SESSION['ERROR_MESSAGE'] = "There is an error. Please try again later!";
            header("Location: ".Application::$HOST."/admin/add-category");
        }
    }
}