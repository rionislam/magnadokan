<?php

use Core\Services\ResourceLoader;
use Core\Services\HtmlGenerator;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags('Fair Use'))?>
</head>
<body>
    <!-- Show if there is any user notification -->
    <?=ResourceLoader::loadNotification()?>

    <!-- Load the fixed login-signup form -->
    <?=ResourceLoader::loadComponent('login-signup')?>

    <!-- Load the downloads left -->
    <?=ResourceLoader::loadComponent('downloads-left')?>
    <main>
        <!-- Load the header -->
        <?=ResourceLoader::loadComponent('header')?>
        <section class="center max-width">
        <article style="max-width: 65rem; margin: auto;" id="post-2265" class="posts-entry fbox post-2265 page type-page status-publish hentry">
            <header class="entry-header">
                <h1 style="color: var(--normal-text-color); margin: 1rem 0;" class="entry-title">Fair Use Act Disclaimer</h1>	
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
    <!-- Load the footer -->
    <?=ResourceLoader::loadComponent('footer')?>

    <!-- The default javascript -->
    <?=ResourceLoader::loadAppJs()?>
    
    <!-- Load gtag for google services intrigration -->
    <?=ResourceLoader::loadGtag()?>
</body>
</html>