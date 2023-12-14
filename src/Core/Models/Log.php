<?php
namespace Core\Models;
class Log extends Dbh{
    protected function addBookLogs($event, $userIp, $userLogedIn, $userId, $userCountry, $pageUrl, $bookId, $bookCategory){
        $this->createRow('bookLogs',['event', 'userIp', 'userLoggedIn', 'userId', 'userCountry', 'pageUrl', 'bookId', 'bookCategory', 'clientId'], 'ssiississ', $event, $userIp, $userLogedIn, $userId, $userCountry, $pageUrl, $bookId, $bookCategory, (isset($_COOKIE['CLIENT_ID'])?$_COOKIE['CLIENT_ID']:$_SESSION['CLIENT_ID']));
    }

}