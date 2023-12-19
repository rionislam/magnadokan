<?php
namespace Core\Models;

use Core\Utilities\Cache;
use Core\Utilities\Timer;

class Category extends Dbh{
    public function getPopularCategories(){
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem("popularCategories");
        if(is_null($cacheInstance->get())){
            $sql = "SELECT
                    bookCategory,
                    COALESCE(SUM(CASE 
                                    WHEN `event` = 'download' THEN 1
                                    WHEN `event` = 'click' THEN 1
                                    ELSE 0 END), 0) AS score
                    
                FROM
                    bookLogs 
                WHERE
                    logTime >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                GROUP BY
                    bookCategory
                ORDER BY
                    score DESC;";
            $rows = $this->getRows($sql);
            $cacheInstance->set($rows)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
        }else{
            $rows = $cacheInstance->get();
        }
        return $rows;
        
    }

    public function get($category){
        $sql = 'SELECT * FROM `categories` WHERE `category`="'.$category.'";';
        $row = $this->getRows($sql)[0];
        return $row;
    }

    public function count($condition = NULL){
        $sql= "SELECT * FROM `categories` {$condition};";
        $result = $this->getResult($sql);
        return $result->num_rows;
    }

    public function getAll(){
        $rows = $this->selectAll('categories');
        return $rows;
        
    }

    public function getAllCateogoriesNames(){
        $rows = $this->selectAll('categories');
        $categoriesName = array();
        if($rows !== false){
            foreach($rows as $row){
                array_push($categoriesName, $row['category']);
            }
            return $categoriesName;
        }else{
            return false;
        }
    }

    public function add($name, $icon){
        $response = $this->createRow('categories', ['`category`', '`categoryIcon`'], 'ss', $name, $icon);
        return $response;
    }

    protected function getLimited($limit, $condition){
        $sql = "SELECT * FROM `categories` {$condition} Limit {$limit};";
        $row = $this->getRows($sql);
        return $row;
    }


    

    public function click($category){
        $clicks = $this->get($category)['clicks']+1;
        $this->updateData('categories', ['clicks'], 'i', " WHERE `category`='{$category}'", $clicks);
    }

    public function download($category){
        $downloads = $this->get($category)['downloads']+1;
        $this->updateData('categories', ['downloads'], 'i', " WHERE `category`='{$category}'", $downloads);
    }
}