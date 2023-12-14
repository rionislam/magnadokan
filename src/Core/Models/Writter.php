<?php
namespace Core\Models;

use Core\Application;

class  Writter extends Dbh{
    public function add($name, $writterImage){
       
            $response = $this->createRow('writters', ['`writterName`', '`writterImg`'], 'ss', $name, $writterImage);
            return $response;
    }

    public function getAll(){
        $rows = $this->selectAll('writters');
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