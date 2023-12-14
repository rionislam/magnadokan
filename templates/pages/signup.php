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
    <title>Signup - Magna Dokan</title>
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
        <?php include "includes/header.inc.php"?>
        <section class="login_signup">
            <div class="login_signup-form_container">
                <div class="warning">
                        <?php
                        if(isset($_GET['error'])){
                            if($_GET['error'] == 'username_email_exists'){
                                echo "Username and email already exists!";
                            }else if($_GET['error'] == 'username_exists'){
                                echo "Username already exists!";
                            }else if($_GET['error'] == 'email_exists'){
                                echo "Email already exists!";
                            }
                        }
                        ?>
                </div>
            <form id="signup-form" action="<?=App\Application::$HOST?>/controllers/user-signup.controller.php" method="post">
                <div class="input-container">
                    <div class="input-name">Full Name</div>
                    <input type="text" name="full-name" required>
                </div>
                <div class="input-container">
                    <div class="input-name">User Name</div>
                    <input type="text" pattern="[A-Za-z0-9]+" name="username" required>
                </div>
                <div class="input-container">
                    <div class="input-name">Email</div>
                    <input type="email" name="email"  required>
                </div>
                <div class="input-container">
                    <div class="input-name">Password</div>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="input-container">
                    <div class="input-name">Confirm Password</div>
                    <input type="password" name="confirm-password" id="confirm-password">
                </div>
                <div class="login_singup-link">
                        Already signed up! <a href="<?=App\Application::$HOST?>/login">Login.</a>
                </div>
                <input type="submit" value="Signup">
            </form>
            </div>
        </section>
        <?php include "includes/footer.inc.php"?>
    <script>
        let signup_form = document.getElementById('signup-form');
        let full_name = document.getElementsByName('full-name')[0];
        let username = document.getElementsByName('username')[0];
        let password = document.getElementById('password');
        let confirm_password = document.getElementById('confirm-password');
        username.addEventListener('invalid', ()=>{
            if (username.validity.patternMismatch) {
                username.setCustomValidity('Username can\'t contain any special carrecter or space!');
                
            }
        })

        username.addEventListener('change', ()=>{
            username.setCustomValidity("");
        })

        signup_form.addEventListener('submit', (e)=>{
            if(password.value !== confirm_password.value){
                e.preventDefault();
                confirm_password.setCustomValidity('This doesn\'t match with the password!');
                confirm_password.reportValidity();
            }
        })

        confirm_password.addEventListener('change', ()=>{
            username.setCustomValidity('');
        })
        
    </script>
</body>
</html>