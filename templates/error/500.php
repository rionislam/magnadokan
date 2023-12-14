<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

use Core\Services\ResourceLoader;
use Core\Services\HtmlGenerator;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags('500 - Internal Server Error'))?>
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
            <h1>500</h1>
            <p>Internal Server Error!</p>
        </div>
    </main>
        <!-- Load the footer -->
        <?=ResourceLoader::loadComponent('footer')?>
</body>
</html>