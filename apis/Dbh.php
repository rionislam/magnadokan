<?php
namespace App;

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.inc.php');
class Dbh{
    private $dbName = dbName;
    private $dbUser = dbUser;
    private $dbPass = dbPass;
    private $dbHost = dbHost;

    protected function connect(){
        $mysqli = new \mysqli($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);
        if($mysqli->connect_errno){
            return $mysqli->connect_error;
        }else{
            return $mysqli;
        }
    }
    
    protected function selectAll($table){
        $sql = 'SELECT * FROM '.$table;
        return $this->getRows($sql);
    }

    protected function getResult($sql){
        $result = $this->connect()->query($sql);
        return $result;
    }

    protected function getRows($sql){
        $result = $this->getResult($sql);
        if($result->num_rows > 0){
            $rows = [];
            while($row = $result->fetch_assoc()){
                array_push($rows, $row);
            }
            return $rows;
        }else{
            return false;
        }
        
    }

    protected function createRow($table, $columns, $dataTypes, ...$data){
        $columnsString = '';
        $valuesString = '';
        foreach($columns as $colum){
            $columnsString .= $colum .',';
            $valuesString .= '?,';
        }
        $columnsString = rtrim($columnsString, ',');
        $valuesString = rtrim($valuesString, ',');

        $sql = "INSERT into `{$table}`($columnsString) VALUES({$valuesString});";
        $dbConn =  $this->connect();
        $stmt = $dbConn->stmt_init();
        if(!$stmt->prepare($sql)){
            return false;
            exit;
        }
        $stmt->bind_param($dataTypes, ...$data);
        $stmt->execute();
        $stmt->close();
        return $dbConn->insert_id;
    }

    protected function updateData($table, $columns, $dataTypes, $condtion, ...$data){
        $columnsString = '';
        foreach($columns as $colum){
            $columnsString .= $colum .'= ?,';
        }
        $columnsString = rtrim($columnsString, ',');
        

        $sql = "UPDATE `{$table}`SET {$columnsString} {$condtion};";
        $dbConn =  $this->connect();
        $stmt = $dbConn->stmt_init();
        if(!$stmt->prepare($sql)){
            return false;
            exit;
        }
        $stmt->bind_param($dataTypes, ...$data);
        $stmt->execute();
        $stmt->close();
        return true;
    }

}