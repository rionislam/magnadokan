<?php
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags('401 - Unauthorized Request'))?>
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
        <div class="error-container">
            <h1>401</h1>
            <p>Authorization Required!</p>
        </div>
    </main>
        <!-- Load the footer -->
        <?=ResourceLoader::loadComponent('footer')?>
</body>
</html>