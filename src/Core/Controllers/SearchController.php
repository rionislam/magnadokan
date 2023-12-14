<?php
namespace Core\Controllers;
use Core\Application;
use Core\Services\ResourceLoader;

class SearchController{
    public function search(){
        $search = $_POST['search'];
        header("Location: ".Application::$HOST."/search/{$search}/1");
    }
}