<?php
namespace App;

class Log extends Dbh{
    public function add($event, $userIp, $userLogedIn, $userId=Null, $userOs, $userBrowser, $userCountry, $pageUrl, $contentType, $contentId){
        $this->createRow('userLogs',['event', 'userIp', 'userLoggedIn', 'userId', 'userOs', 'userBrowser', 'userCountry', 'pageUrl', 'contentType', 'contentId'], 'ssiisssssi', $event, $userIp, $userLogedIn, $userId, $userOs, $userBrowser, $userCountry, $pageUrl, $contentType, $contentId);
    }

    public function click($contentType, $contentId){
        $client = new Client;
        $user = new User;
        $this->add('click', $client->getIp(), $user->logedIn(), ($user->logedIn())?$_SESSION['userId']:'', $client->getOs(), $client->getBrowser(), $client->getCountry(),  $_SERVER['HTTP_REFERER'], $contentType, $contentId);
    }
}

