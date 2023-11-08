<?php
namespace App;

class Log extends Dbh{
    private function addBookLogs($event, $userIp, $userLogedIn, $userId=Null, $userOs, $userBrowser, $userCountry, $pageUrl, $bookId, $bookCategory){
        $this->createRow('bookLogs',['event', 'userIp', 'userLoggedIn', 'userId', 'userOs', 'userBrowser', 'userCountry', 'pageUrl', 'bookId', 'bookCategory'], 'ssiissssis', $event, $userIp, $userLogedIn, $userId, $userOs, $userBrowser, $userCountry, $pageUrl, $bookId, $bookCategory);
    }

    public function collectClick($bookId, $bookCategory){
        $client = new Client;
        $user = new User;
        $this->addBookLogs('click', $client->getIp(), $user->logedIn(), ($user->logedIn())?$_SESSION['userId']:'', $client->getOs(), $client->getBrowser(), $client->getCountry(),  $_SERVER['HTTP_REFERER'], $bookId, $bookCategory);
    }

    public function collectImpression($bookId, $bookCategory){
        $client = new Client;
        $user = new User;
        $this->addBookLogs('impression', $client->getIp(), $user->logedIn(), ($user->logedIn())?$_SESSION['userId']:'', $client->getOs(), $client->getBrowser(), $client->getCountry(),  $_SERVER['HTTP_REFERER'], $bookId, $bookCategory);
    }

    public function collectDownload($bookId, $bookCategory){
        $client = new Client;
        $user = new User;
        $this->addBookLogs('download', $client->getIp(), $user->logedIn(), ($user->logedIn())?$_SESSION['userId']:'', $client->getOs(), $client->getBrowser(), $client->getCountry(),  $_SERVER['HTTP_REFERER'], $bookId, $bookCategory);
    }

    

}

