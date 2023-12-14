<?php

use Core\Application;
use Core\Controllers\LibraryController;
use Core\Services\ResourceLoader;
use Core\Services\HtmlGenerator;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

$libraryController = new LibraryController;
$application = new Application;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags('Library', 'My library'), 'library', true)?>
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
        <section class="library max-width center">
            <header>
                <div class="title">My Library</div> 
            </header>
            <hr>
            <div class="books-container">
                <?=$libraryController->load();?>
            </div>
        </section>
    </main>
    <!-- Load the footer -->
    <?=ResourceLoader::loadComponent('footer')?>
    <!-- The default javascript -->
    <?=ResourceLoader::loadAppJs()?>
</body>
</html>
