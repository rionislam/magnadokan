<?php
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
    <title>401 - Unauthorized Request | Magna Dokan</title>
    <meta name="description" content="We provide free pdf version of books to those people who can't affort to buy the original copy of the books. You can 
                pdf of any book from our website for free. Although we always suggest to buy the real copy of the book.
                We do it all for educational purpous only. We also promote the original copy of the books we provide through our
                website. Most of the writters and pubblisher don't mind if their books are distributed to the underprivileged people
                for free. If anyone mind and don't want their content to be distributed for free they can place a request and we will 
                remove their content according to the DMCA policy.">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=App\Application::$HOST?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=App\Application::$HOST?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=App\Application::$HOST?>/favicon-16x16.png">
    <link rel="manifest" href="<?=App\Application::$HOST?>/menifest.json">
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/css/global.css">
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/css/style.css">
    <script src="js/functions.js"></script>
</head>
<body>
    <?php include App\Application::$ROOT_DIR."/includes/login-signup.inc.php"?>
    <main>
        <?php include App\Application::$ROOT_DIR."/includes/header.inc.php"?>
        <div class="error-container">
            <h1>401</h1>
            <p>Authorization Required!</p>
        </div>
        <?php include App\Application::$ROOT_DIR."/includes/footer.inc.php"?>
    </main>
</body>
</html>