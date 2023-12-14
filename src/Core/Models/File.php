<?php
namespace Core\Models;

class File extends Dbh{
    
    

    public function add($fileName, $purpous){
        $response = $this->createRow('files', ['fileName', 'filePurpous'], 'ss', $fileName, $purpous);
    }

    public function changeStatus($condition, $status){
        $this->updateData('files', ['fileStatus'], 's', $condition, $status);
    }

    

    // public function get($fileUniqueId){
    //     $sql = "SELECT * FROM `files` WHERE `fileUniqueId`='{$fileUniqueId}'";
    //     $row = $this->getRows($sql)[0];
    //     return $row;
    // }
}