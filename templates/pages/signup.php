<?php
use Core\Application;
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;
$application = new Application;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags('Sign Up'), 'login-signup', true)?>
</head>
<body>
        <!-- Load gtag for google services intrigration -->
        <?=ResourceLoader::loadGtag()?>
        
        <!-- Show if there is any user notification -->
        <?=ResourceLoader::loadNotification()?>

        <!-- Load the fixed login-signup form -->
        <?=ResourceLoader::loadComponent('login-signup')?>
    <main>
        <!-- Load the header -->
        <?=ResourceLoader::loadComponent('header')?>
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
            <form id="signup-form" action="<?=Application::$HOST?>/process-signup" method="post">
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
                        Already signed up! <a href="<?=Application::$HOST?>/login">Login.</a>
                </div>
                <input type="submit" value="Signup">
            </form>
            </div>
        </section>
        <!-- Load the footer -->
        <?=ResourceLoader::loadComponent('footer')?>
        <!-- The default javascript -->
        <?=ResourceLoader::loadAppJs()?>
    </main>   
</body>
</html>
