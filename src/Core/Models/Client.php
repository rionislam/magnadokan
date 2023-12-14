<?php

namespace Core\Models;

use Core\Services\ClientService;

class Client extends Dbh{
    protected function add(){
        $clientUid = bin2hex(random_bytes(16));
        if($this->createRow('clients', ['clientUid', 'clientOs', 'clientBrowser', 'clientLastLocation', 'clientLastIp', 'clientDevice'], 'ssssss', $clientUid, ClientService::getOs(), ClientService::getBrowser(), ClientService::getCountry(), ClientService::getIp(), ClientService::getDeviceType())){
            setcookie('CLIENT_ID', $clientUid, time()+365*24*3600, '/', $_SERVER['HTTP_HOST'], false, true);
            $_SESSION['CLIENT_ID'] = $clientUid;
            return true;
        }else{
            return false;
        }
    }

    protected function update(){
        date_default_timezone_set('UTC');
        return $this->updateData('clients', ['clientLastLocation', 'clientLastIp', 'clientLastActive'], 'sss', "WHERE `clientUid`='{$_COOKIE['CLIENT_ID']}'", ClientService::getCountry(), ClientService::getIp(), date('Y-m-d H:i:s', time()));
    }

    

}