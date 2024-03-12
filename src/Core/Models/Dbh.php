<?php

namespace Core\Models;

require_once($_SERVER['DOCUMENT_ROOT'].'/config/database.php');

class Dbh {
    private $dbName = dbName;
    private $dbUser = dbUser;
    private $dbPass = dbPass;
    private $dbHost = dbHost;
    private $pdo;

    public function __construct() {
        $dsn = "mysql:host={$this->dbHost};dbname={$this->dbName};charset=utf8";
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new \PDO($dsn, $this->dbUser, $this->dbPass, $options);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }

        $this->setSessionVariables();
    }

    private function setSessionVariables() {
        $this->pdo->exec("SET SESSION collation_connection ='utf8_general_ci'");
        $this->pdo->exec("SET SESSION time_zone ='+00:00'");
    }

    
    protected function executeQuery(string $sql, array $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            
            if ($stmt === false) {
                return false; // Query preparation failed
            }
            
            $stmt->execute($params);
            
            // Check if the query is a SELECT statement
            if (stripos(trim($sql), 'SELECT') !== false) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                return true; // For non-SELECT statements (INSERT, UPDATE, DELETE)
            }
        } catch (\PDOException) {
            return false;
        }
    }
    
    protected function getRows(string $sql, array $params = []) {
        $rows = $this->executeQuery($sql, $params);
        return $rows ? $rows : false;
    }

    protected function selectAll(string $table) {
        $sql = 'SELECT * FROM ' . $table;
        return $this->getRows($sql);
    }
    

    protected function createRow(string $table, array $columns, string $dataTypes, ...$data) {
        $columnsString = implode(',', $columns);
        $valuesString = rtrim(str_repeat('?,', count($columns)), ',');
        $sql = "INSERT INTO {$table} ({$columnsString}) VALUES ({$valuesString})";
        if($this->executeQuery($sql, $data) != false){
            return $this->pdo->lastInsertId();
        }else{
            return false;
        }
        
    }

    protected function updateData(string $table, array $columns, string $dataTypes, string $condition, ...$data) {
        $setParams = implode('=?,', $columns) . '=?';
        $sql = "UPDATE {$table} SET {$setParams} {$condition}";
        if($this->executeQuery($sql, $data) != false){
            return true;
        }else{
            return false;
        }
    }

    protected function deleteRow(string $table, string $idColName, int $id) {
        $sql = "DELETE FROM {$table} WHERE {$idColName}=?";
        if($this->executeQuery($sql, [$id]) != false){
            return true;
        }else{
            return false;
        }
    }

    protected function rowExists(string $table, string $condition) {
        $sql = "SELECT 1 FROM {$table} WHERE {$condition}";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ? true : false;
    }
}
