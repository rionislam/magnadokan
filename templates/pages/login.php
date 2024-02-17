<?php
use Core\Application;
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;
$application = new Application;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags('Login'), 'login-signup', true)?>
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
                    if(isset($_GET['error']) && $_GET['error'] == 'wrong_login'){
                        echo "Login or password is wrong!";
                    }
                    ?>
                    
                </div>
                <form action="<?=Application::$HOST?>/process-login" method="post">
                <div class="input-container">
                    <div class="input-name">Email or Username</div>
                    <input type="text" name="user-login" <?php if(isset($_GET['login'])){echo 'value='.$_GET['login'];} ?> required>
                </div>
                <div class="input-container">
                    <div class="input-name">Password</div>
                    <input type="password" name="password" required>
                </div>
                <div class="login_singup-link">
                    Don't have an account? <a href="<?=Application::$HOST?>/signup">Signup.</a>
                </div>
                
                <input type="submit" value="Login">
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
