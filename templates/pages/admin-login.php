<?php
define('pageName', 'admin-login');
use Core\Application;
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateAdminHead('Login', pageName)?>
</head>
<body>
    <?=ResourceLoader::loadNotification()?>
    <section class="login_signup">
            <div class="login_signup-form_container">
            <form action="<?=Application::$HOST?>/admin/process-login" method="post">
                <div class="input-container">
                    <div class="input-name">Username or Email Address</div>
                    <input type="text" name="admin-login" id="admin-login" required>
                </div>
                <div class="input-container">
                    <div class="input-name">Password</div>
                    <input type="password" name="admin-password" id="admin-password" required>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" name="remember-login" checked>
                    <div class="checkbox-name">Remember me</div>
                </div>
                <input type="submit" value="Login" id="button_login">
            </form>
        </div>
    </section>
</body>
</html>