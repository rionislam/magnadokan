<?php
@session_start();
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use App\Client;
$client = new Client;
$client->check();
$application = new App\Application;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="var(--accent-1)" />
    <title>Login - Magna Dokan</title>
    <meta name="description" content="We provide free pdf version of books to those people who can't affort to buy the original copy of the books. You can 
                pdf of any book from our website for free. Although we always suggest to buy the real copy of the book.
                We do it all for educational purpous only. We also promote the original copy of the books we provide through our
                website. Most of the writters and pubblisher don't mind if their books are distributed to the underprivileged people
                for free. If anyone mind and don't want their content to be distributed for free they can place a request and we will 
                remove their content according to the DMCA policy.">
    <base href="<?=App\Application::$HOST?>/"/>
    <link rel="apple-touch-icon" sizes="180x180" href="<?=App\Application::$HOST?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=App\Application::$HOST?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=App\Application::$HOST?>/favicon-16x16.png">
    <link rel="manifest" href="<?=App\Application::$HOST?>/menifest.json">
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/css/global.css">
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/css/style.css">
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/css/login-signup.css">
</head>
<body>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9CHSKS37J3"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-9CHSKS37J3');
    </script>
    <main>
        <?php include "includes/header.inc.php"?>
        <section class="login_signup">
            <div class="login_signup-form_container">
                <div class="warning">
                    <?php
                    if(isset($_GET['error']) && $_GET['error'] == 'wrong_login'){
                        echo "Login or password is wrong!";
                    }
                    ?>
                    
                </div>
                <form action="http://localhost/controllers/user-login.controller.php" method="post">
                <div class="input-container">
                    <div class="input-name">Email or Username</div>
                    <input type="text" name="user-login" <?php if(isset($_GET['login'])){echo 'value='.$_GET['login'];} ?> required>
                </div>
                <div class="input-container">
                    <div class="input-name">Password</div>
                    <input type="password" name="password" required>
                </div>
                <div class="login_singup-link">
                    Don't have an account? <a href="<?=App\Application::$HOST?>/signup">Signup.</a>
                </div>
                
                <input type="submit" value="Login">
                </form>
            </div>
        </section>
        <?php include "includes/footer.inc.php"?>
    </main>   
</body>
</html>
