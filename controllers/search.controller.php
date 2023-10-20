<?php

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
new App\Application;
$search = $_POST['search'];
header("Location: ".App\Application::$HOST."/books/search={$search}");
