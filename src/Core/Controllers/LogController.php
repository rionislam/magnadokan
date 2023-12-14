<?php
namespace Core\Controllers;

use Core\Services\Logger;

class LogController extends Logger{
    public function collectBookLog($event = NULL, $bookId = NULL, $bookCategory = NULL){
        if($event == NULL && $bookId == NULL && $bookCategory == NULL){
            $data = json_decode(file_get_contents('php://input'));
            $event  =$data->event;
            $bookId = $data->bookId;
            $bookCategory = $data->bookCategory;
        }
        
        if($event == 'impression'){
            $this->collectBookImpression($bookId, $bookCategory);
        }else if($event == 'click'){
            $this->collectBookClick($bookId, $bookCategory);
        }else if($event == 'download'){
            $this->collectBookDownload($bookId, $bookCategory);
        }
    }
}