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
                <input type="text" pattern="^[a-zA-Z\s]+$" id="fullName" name="full-name" required>
            </div>
            <div class="input-container">
                <div class="input-name">User Name</div>
                <input type="text" id="username" name="username" pattern="^[a-zA-Z0-9_\-]+$" minlength="5" required>
            </div>
            <div class="input-container">
                <div class="input-name">Email</div>
                <input type="email" id="email" name="email"  required>
            </div>
            <div class="input-container">
                <div class="input-name">Password</div>
                <input type="password" name="password" id="password" minlength="6" required>
                <img onclick="togglePassword(this)" src="assets/images/icons/visible.svg">
            </div>
            <div class="input-container">
                <div class="input-name">Confirm Password</div>
                <input type="password" name="confirm-password" id="confirmPassword">
                <img onclick="togglePassword(this)" src="assets/images/icons/visible.svg">
            </div>
            <input id="signupBtn" type="submit" value="Signup">
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