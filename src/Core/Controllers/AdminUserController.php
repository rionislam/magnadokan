<?php
namespace Core\Controllers;

use Core\Models\User;
use Core\Services\AdminAuthHandler;
use Core\Services\ErrorHandler;
use Core\Utilities\Cache;
use Core\Utilities\Timer;

class AdminUserController extends User{
    // NOTE - Comparing 30 days
    public function usersIncreased(){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $increased = 0;
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem('usersIncreased');
        if(is_null($cacheInstance->get())){
            $signedUpThisMonth = $this->getRows("SELECT COUNT(*) AS count FROM users WHERE DATE(userSignedUpAt) < DATE(NOW()) AND DATE(userSignedUpAt) > DATE(NOW() - INTERVAL 30 DAY);")[0]['count'];
            $signedUpPreviousMonth = $this->getRows("SELECT COUNT(*) AS count FROM users WHERE DATE(userSignedUpAt) < DATE(NOW() - INTERVAL 30 DAY) AND DATE(userSignedUpAt) > DATE(NOW() - INTERVAL 60 DAY);")[0]['count'];
            if ($signedUpPreviousMonth != 0) {
                $increased = floor((($signedUpThisMonth - $signedUpPreviousMonth) / $signedUpPreviousMonth) * 100);
            } else {
                // Handle the case where signedUpPreviousMonth is 0 to avoid division by zero
                $increased = 100;
            }
            $cacheInstance->set($increased)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
        }else{
            $increased = $cacheInstance->get();
        }

        return $increased;
    }

    public function loadAll(){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $rows = $this->getAll();
        if($rows !== false){
            foreach($rows as $row){
                echo "<div class='row''>
                        <div class='user-name'>".$row['userName']."</div>
                        <div class='user-full-name'>".$row['userFullName']."</div>
                        <div class='user-email'>".$row['userEmail']."</div>
                        <div class='user-status'>".$row['userStatus']."</div>
                    </div>";
            }
        }else{
            echo 'Nothing found!';
        }
    }
}