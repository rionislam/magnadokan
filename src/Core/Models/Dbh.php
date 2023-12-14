<?php
namespace Core\Models;

require_once($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
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
            $mysqli->query('SET CHARACTER SET utf8');
            $mysqli->query("SET SESSION collation_connection ='utf8_general_ci'");
            $mysqli->query("SET SESSION time_zone ='+00:00'");
            return $mysqli;
        }
    }
    
    protected function selectAll(string $table){
        $sql = 'SELECT * FROM '.$table;
        return $this->getRows($sql);
    }

    protected function getResult(string $sql){
        $result = $this->connect()->query($sql);
        return $result;
    }

    protected function getRows(string $sql){
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

    protected function createRow(string $table, array $columns, string $dataTypes, ...$data){
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

    protected function updateData(string $table, array $columns, string $dataTypes, string $condtion, ...$data){
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

    protected function deleteRow(string $table, string $idColName, int $id){
        $sql = "DELETE  FROM `{$table}` WHERE `{$idColName}`=?;";
        $dbConn =  $this->connect();
        $stmt = $dbConn->stmt_init();
        if(!$stmt->prepare($sql)){
            return false;
            exit;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    protected function rowExists(string $table,string $condtion){
        $sql = "SELECT 1 FROM `{$table}` WHERE $condtion";
        $dbConn =  $this->connect();
        $result = $dbConn->query($sql);
        if($result->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

}