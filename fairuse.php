<?php

@session_start();
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
    <title>Magna Dokan - Fair use</title>
    <meta name="description" content="We provide free pdf version of books to those people who can't affort to buy the original copy of the books. You can 
                pdf of any book from our website for free. Although we always suggest to buy the real copy of the book.
                We do it all for educational purpous only. We also promote the original copy of the books we provide through our
                website. Most of the writters and pubblisher don't mind if their books are distributed to the underprivileged people
                for free. If anyone mind and don't want their content to be distributed for free they can place a request and we will 
                remove their content according to the DMCA policy.">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/functions.js"></script>
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
    <?php include "includes/login-signup.inc.php"?>
    <main>
        <?php include "includes/header.inc.php"?>
        <section class="center max-width">
        <article style="max-width: 65rem; margin: auto;" id="post-2265" class="posts-entry fbox post-2265 page type-page status-publish hentry">
            <header class="entry-header">
                <h1 style="color: black; margin: 1rem 0;" class="entry-title">Fair Use Act Disclaimer</h1>	
            </header>

            <div class="entry-content">
                <p>This site is for educational purposes only. We always promote the real work and engourage people to show support to the real owner.</p>
                <p  style="margin: 1rem 0;"><strong>Fair Use</strong></p>
                <p>Copyright Disclaimer under section 107 of the Copyright Act of 1976, allowance is made for “fair use” for purposes such as criticism, comment, news reporting, teaching, scholarship, education and research.</p>
                <p>Fair use is a use permitted by copyright statute that might otherwise be infringing.</p>
                <p  style="margin: 1rem 0;"><strong>Fair Use Definition</strong></p>
                <p>Fair use is a doctrine in United States copyright law that allows limited use of copyrighted material without requiring permission from the rights holders, such as commentary, criticism, news reporting, research, teaching or scholarship. It provides for the legal, non-licensed citation or incorporation of copyrighted material in another author’s work under a four-factor balancing test.</p>
            </div>
        </article>
        </section>
    </main>
    <?php include "includes/footer.inc.php"?>
    <script src="js/script.js"></script>
</body>
</html>