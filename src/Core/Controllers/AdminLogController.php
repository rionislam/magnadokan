<?php
namespace Core\Controllers;

use Core\Services\AdminAuthHandler;
use Core\Services\ErrorHandler;
use Core\Services\Logger;
use Core\Utilities\Cache;
use Core\Utilities\Timer;

class AdminLogController extends Logger{
    public function downloadsCount(){
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem("dwonloadsCount");
        if(is_null($cacheInstance->get())){
            $sql= "SELECT * FROM `bookLogs` WHERE `event`='download';";
            $result = $this->getResult($sql);
            $cacheInstance->set($result->num_rows)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
            return $result->num_rows;
        }else{
            return $cacheInstance->get();
        }
    }

    public function downloadsIncreased(){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $increased = 0;
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem('downloadsIncreased');
        if(is_null($cacheInstance->get())){
            $downloadsThisMonth = $this->getRows("SELECT COUNT(*) AS count FROM bookLogs WHERE `event`='download' AND DATE(logTime) < DATE(NOW()) AND DATE(logTime) > DATE(NOW() - INTERVAL 30 DAY);")[0]['count'];
            $downloadsPreviousMonth = $this->getRows("SELECT COUNT(*) AS count FROM bookLogs WHERE `event`='download' AND DATE(logTime) < DATE(NOW() - INTERVAL 30 DAY) AND DATE(logTime) > DATE(NOW() - INTERVAL 60 DAY);")[0]['count'];
            if ($downloadsPreviousMonth != 0) {
                $increased = floor((($downloadsThisMonth - $downloadsPreviousMonth) / $downloadsPreviousMonth) * 100);
            } else {
                // Handle the case where downloadsPreviousMonth is 0 to avoid division by zero
                $increased = 100;
            }
            $cacheInstance->set($increased)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
        }else{
            $increased = $cacheInstance->get();
        }
    

        return $increased;
    }
}