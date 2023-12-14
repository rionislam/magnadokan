<?php
namespace Core\Models;

use Core\Services\ClientService;

class Session extends Dbh{

    protected function create($userId, $userName, $sessionBrowser=NULL, $sessionOs=NULL, $sessionTimeout=NULL){
        if($sessionBrowser == NULL){
            $sessionBrowser = ClientService::getBrowser();
        }
        if($sessionOs == NULL){
            $sessionOs = ClientService::getOs();
        }
        if($sessionTimeout == NULL){
            $sessionTimeout = time()+30*24*3600;
        }
        $sessionUid = bin2hex(random_bytes(16));
        $response = $this->createRow('userSessions', ['sessionUid', 'sessionBrowser', 'sessionOs', 'sessionTimeout', 'userId', 'userName', 'clientId'], 'sssiiss', $sessionUid, $sessionBrowser, $sessionOs, $sessionTimeout, $userId, $userName, $_COOKIE['CLIENT_ID']);
        if($response != false){
            //TODO - change the secure to true
            setcookie('SESSION_ID', $sessionUid, $sessionTimeout, '/', $_SERVER['HTTP_HOST'], false, true);
        }
    }

    protected function changeStatus($sessionId, $status){
        $response = $this->updateData('userSessions', ['sessionStatus'], 's', "WHERE `sessionUid`='$sessionId'", $status);
        return $response;
    }

    //TODO - Need to secure the validation process using client footprint
    protected function validate(){
            $sessionUid = $_COOKIE['SESSION_ID'];
            $currentTime = time();
            $sql = "SELECT * FROM `userSessions` WHERE `sessionUid`='{$sessionUid}' and `sessionStatus`='active'";
            $rows = $this->getRows($sql);
            if($rows == false){
                return false;
                exit;
            }
            $row = $rows[0];
            if($row['sessionTimeout'] > $currentTime){
                $_SESSION['USER_ID'] = $row['userId'];
                $_SESSION['USER_Name'] = $row['userName'];
                $this->updateData('userSessions', ['sessionLastIp', 'sessionLastCountry'], 'ss', "WHERE `sessionUid`='{$sessionUid}'", ClientService::getIp(), ClientService::getCountry());
            }else{
                $this->updateData('userSessions', ['sessionStatus'], 's', "WHERE `sessionUid`='{$sessionUid}'", 'expired');
            }
    }
}
