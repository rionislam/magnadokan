<?php

use Core\Application;
use Core\Services\ResourceLoader;
use Core\Services\SessionService;

if(!SessionService::isLoggedIn()){
?>
<?=ResourceLoader::loadComponentCss('downloads-left')?>
<section class="downloads-left">
    <div class="downloads-left-container">
        <div class="title">Downloads Left</div>
        <hr>
        <div class="downloads-left-number">0</div>
        <hr>
        <div class="time-left">
            <div class="hour">
                <div class="int">
                    2
                </div>
                <div class="int">
                    3
                </div>
            </div>
            :
            <div class="min">
                <div class="int">
                    5
                </div>
                <div class="int">
                    9
                </div>
            </div>
            :
            <div class="sec">
                <div class="int">
                    5
                </div>
                <div class="int">
                    9 
                </div>
            </div>
        </div>
        <div class="time-notice">Remeining for next refresh</div>
        <div class="notice">Please login for unlimited downloads!</div>
    </div>
</section>
<?=ResourceLoader::loadComponentJs('downloads-left')?>
<?php
}
?>