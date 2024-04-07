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
            <p>Welcome to Magna Dokan, your ultimate destination for accessing free PDF versions of books when financial constraints stand in the way of owning the original copies. At Magna Dokan, we believe in equal access to knowledge regardless of economic status. Whether you're a student, an avid reader, or someone with a thirst for knowledge, our platform offers a wide array of books that you can download at no cost.
                <br/>
                <br/>
                Our mission is simple: to bridge the gap between those who can afford books and those who cannot. If you're unable to find a specific book on our website, simply submit a request, and we'll strive to upload it promptly. However, while we offer free access to these materials, we also encourage our users to support authors and publishers by purchasing the original copies whenever possible. Your patronage not only supports the authors' livelihoods but also ensures the continuation of their literary contributions.
                <br/>
                <br/>
                At Magna Dokan, we operate with integrity and respect for intellectual property rights. While most authors and publishers generously allow the distribution of their works for educational purposes, we understand that some may have reservations. In such cases, we adhere to the DMCA policy and promptly remove any content upon request.
                <br/>
                <br/>
                Join us in our quest to democratize access to literature and empower individuals from all walks of life through the power of knowledge. Dive into the world of literature, expand your horizons, and embark on a journey of enlightenment with Magna Dokan. 
            </p>
        </section>
        
    </main>

    <!-- Load the footer -->
    <?=ResourceLoader::loadComponent('footer')?>
    <script src="js/app.js"></script>
</body>
</html>