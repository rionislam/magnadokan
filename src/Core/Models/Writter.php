<?php
namespace Core\Models;

class  Writter extends Dbh{

    //NOTE - Get the number of writters
    public function count($condition = NULL){
        $sql= "SELECT * FROM `writters` {$condition};";
        $rows = $this->getRows($sql);
        return count($rows);
    }

    public function add($name, $writterImage){
       
            $response = $this->createRow('writters', ['`writterName`', '`writterImg`'], 'ss', $name, $writterImage);
            return $response;
    }

    public function getAll($page = NULL){
        if($page == NULL){
            $rows = $this->selectAll('writters');
        }else{
            $starting = 0 + 10 * ($page-1);
            $limit = 10;
            $sql = "SELECT * FROM
                    `writters` 
                    LIMIT
                        {$starting},{$limit};";
            $rows = $this->getRows($sql);
        }
        
        return $rows;
        
    }

    public function getAllWrittersName(){
        $rows = $this->selectAll('writters');
        $writtersName = array();
        if($rows !== false){
            foreach($rows as $row){
                array_push($writtersName, $row['writterName']);
            }
            return $writtersName;
        }else{
            return false;
        }
        
    }
}