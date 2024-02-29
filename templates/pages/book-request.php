<?php

use Core\Application;
use Core\Services\HtmlGenerator;
use Core\Services\SessionService;
use Core\Services\ResourceLoader;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
if(!SessionService::isLoggedIn()){
    header("Location:".Application::$HOST);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags('Book Request'), 'book-request')?>
</head>
<body>
    <!-- Show if there is any user notification -->
    <?=ResourceLoader::loadNotification()?>
    <main>
        <!-- Load the header -->
        <?=ResourceLoader::loadComponent('header')?>
        <section class="book_request">
            <div class="form-container">
                <form action="<?=Application::$HOST?>/process-book-request" method="post">
                    <div class="input-container">
                        <div class="input-name">Book Name*</div>
                        <input type="text" name="bookName" id="bookName" placeholder="Book Name" required>
                    </div>
                    <div class="input-container">
                        <div class="input-name">Writters*</div>
                        <input type="text" name="bookWritters" id="bookWritters" placeholder="Writters" required>
                    </div>
                    <div class="input-container">
                        <div class="input-name">Publication Year</div>
                        <input type="number" min="0" max="2099" step="1" value="2023" name="publication" id="publication" placeholder="Year" required>
                    </div>
                    <div class="input-container">
                        <div class="input-name">Note</div>
                        <textarea name="note" id="note" cols="30" rows="5" placeholder="Write something more about the book"></textarea>
                    </div>
                    <input type="submit" value="Submit Request">
                </form>
            </div>
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