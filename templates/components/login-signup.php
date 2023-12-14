<?php

use Core\Application;
use Core\Services\ResourceLoader;
use Core\Services\SessionService;

 if(!SessionService::isLoggedIn()){
 ?>
 <?=ResourceLoader::loadComponentCss('login-signup')?>
<section class="login-signup">
    <div class="forms-container">
        <?php include Core\Application::$ROOT_DIR."/assets/images/icons/close.svg"?>
        <form id="signup-form" action="<?=Application::$HOST?>/process-signup" method="post">
            <div class="input-container">
                <div class="input-name">Full Name</div>
                <input type="text" name="full-name" required>
            </div>
            <div class="input-container">
                <div class="input-name">User Name</div>
                <input type="text" name="username" required>
            </div>
            <div class="input-container">
                <div class="input-name">Email</div>
                <input type="email" name="email"  required>
            </div>
            <div class="input-container">
                <div class="input-name">Password</div>
                <input type="password" name="password" id="password" required>
                <img onclick="togglePassword(this)" src="assets/images/icons/visible.svg">
            </div>
            <div class="input-container">
                <div class="input-name">Confirm Password</div>
                <input type="password" name="confirm-password" id="confirm-password">
                <img onclick="togglePassword(this)" src="assets/images/icons/visible.svg">
            </div>
            <input type="submit" value="Signup">
        </form>
        <hr>
        <form action="<?=Application::$HOST?>/process-login" method="post">
            <div class="input-container">
                <div class="input-name">Email or Username</div>
                <input type="text" name="user-login"  required>
            </div>
            <div class="input-container">
                <div class="input-name">Password</div>
                <input type="password" name="password" required>
                <img onclick="togglePassword(this)" src="assets/images/icons/visible.svg">
            </div>
            <div class="checkbox-container">
                <input type="checkbox" name="remember-login" checked>
                <div class="input-name">Remember me</div>
            </div>
            <input type="submit" value="Login">
        </form>
    </div>
</section>
<?=ResourceLoader::loadComponentJs('login-signup')?>
<?php
}
?>