<?php

use Core\Application;
use Core\Services\ResourceLoader;
use Core\Services\HtmlGenerator;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags('About'))?>
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
        <section class="max-width center" style="margin-top: 2rem;">
            <h1 class="title">About Us</h1>
            <hr style="margin: 1rem 0;">
            <p>We provide free pdf version of books to those people who can't affort to buy the original copy of the books. You can 
                pdf of any book from our website for free. Although we always suggest to buy the real copy of the book.
                We do it all for educational purpous only. We also promote the original copy of the books we provide through our
                website. Most of the writters and pubblisher don't mind if their books are distributed to the underprivileged people
                for free. If anyone mind and don't want their content to be distributed for free they can place a request and we will 
                remove their content according to the DMCA policy. 
            </p>
        </section>
        
    </main>

    <!-- Load the footer -->
    <?=ResourceLoader::loadComponent('footer')?>
    <script src="js/app.js"></script>
</body>
</html>