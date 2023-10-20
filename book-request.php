<?php

use Google\Service\CloudBuild\Warning;

@session_start();
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$application = new App\Application;

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="var(--accent-1)" />
    <title>Request a Book - Magna Dokan</title>
    <base href="<?=App\Application::$HOST?>/"/>
    <link rel="apple-touch-icon" sizes="180x180" href="<?=App\Application::$HOST?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=App\Application::$HOST?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href=<?=App\Application::$HOST?>/favicon-16x16.png">
    <link rel="manifest" href="<?=App\Application::$HOST?>/menifest.json">
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/css/global.css">
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/css/style.css">
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/css/book_request.css">
</head>
<body>
    <main>
        <?php include "includes/header.inc.php"?>
        <section class="book_request">
            <div class="form-container">
                <form action="<?=App\Application::$HOST?>/controllers/book-request.controller.php" method="post">
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
        <?php include "includes/footer.inc.php"?>
    </main>
</body>
</html>