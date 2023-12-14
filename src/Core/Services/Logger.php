<?php
namespace Core\Services;

use Core\Models\Log;

class Logger extends Log{
    public function collectBookClick($bookId, $bookCategory){
        $this->addBookLogs('click', ClientService::getIp(), SessionService::isLoggedIn(), (SessionService::isLoggedIn())?$_SESSION['USER_ID']:'', ClientService::getCountry(),  (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'Direct'), $bookId, $bookCategory);
    }

    public function collectBookImpression($bookId, $bookCategory){
        $this->addBookLogs('impression', ClientService::getIp(), SessionService::isLoggedIn(), (SessionService::isLoggedIn())?$_SESSION['USER_ID']:'', 'Bangladesh',  (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'Direct'), $bookId, $bookCategory);
    }

    public function collectBookDownload($bookId, $bookCategory){
        $this->addBookLogs('download', ClientService::getIp(), SessionService::isLoggedIn(), (SessionService::isLoggedIn())?$_SESSION['USER_ID']:'', ClientService::getCountry(),  (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'Direct'), $bookId, $bookCategory);
    }

}