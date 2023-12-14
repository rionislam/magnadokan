<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags('503 - Service Unavailable'))?>
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
            <h1>503</h1>
            <p>Service Unavailable!</p>
        </div>
    </main>
        <!-- Load the footer -->
        <?=ResourceLoader::loadComponent('footer')?>
</body>
</html>