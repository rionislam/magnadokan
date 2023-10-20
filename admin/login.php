<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
new App\Application;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="var(--accent-1)" />
    <title>Login - Admin | Magna Dokan</title>
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/css/global.css">
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/css/login-signup.css">
</head>
<body>
    <section class="login_signup">
            <div class="login_signup-form_container">
            <form action="<?=App\Application::$HOST?>/controllers/admin-login.controller.php" method="post">
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