<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
@session_start();
$application = new App\Application;
$application->checkAdminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="var(--accent-1)" />
    <title>Admin | Magna Dokan</title>
    <base href="<?=App\Application::$HOST?>/admin/"/>
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/css/global.css">
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/admin/css/style.css">
</head>
<body>
    <script src="<?=App\Application::$HOST?>/admin/js/functions.js"></script>
    <nav>
        <header>
            <h1>Admin Panel</h1>
        </header>
        <hr>
        <ul>
            <li onclick="navigate(this)" data-page="dashboard" <?= (!isset($_GET['p']) || $_GET['p'] == 'dashboard')? 'class="active"':'';?>><a href="<?=App\Application::$HOST?>/admin/p/dashboard"><?php include "../imgs/dashboard.svg";?>Dashboard</a></li>
            <li onclick="navigate(this)" data-page="users" <?= (isset($_GET['p']) && $_GET['p'] == 'users')? 'class="active"':'';?>><a href="<?=App\Application::$HOST?>/admin/p/users"><?php @include "../imgs/users.svg";?>Users</a></li>
            <li onclick="navigate(this)" data-page="books" <?= (isset($_GET['p']) && @$_GET['p'] == 'books' || @$_GET['p'] == 'add-book')? 'class="active"':'';?>><a href="<?=App\Application::$HOST?>/admin/p/books"><?php @include "../imgs/books.svg";?>Books</a></li>
            <li onclick="navigate(this)" data-page="categories" <?= (isset($_GET['p']) && @$_GET['p'] == 'categories' || @$_GET['p'] == 'add-category')? 'class="active"':'';?>><a href="<?=App\Application::$HOST?>/admin/p/categories"><?php @include "../imgs/categories.svg";?>Categories</a></li>
            <li onclick="navigate(this)" data-page="writters" <?= (isset($_GET['p']) && @$_GET['p'] == 'writters' || @$_GET['p'] == 'add-writter')? 'class="active"':'';?>><a href="<?=App\Application::$HOST?>/admin/p/writters"><?php @include "../imgs/writters.svg";?>Writters</a></li>
            <li onclick="navigate(this)" data-page="languages" <?= (isset($_GET['p']) && @$_GET['p'] == 'languages' || @$_GET['p'] == 'add-language')? 'class="active"':'';?>><a href="<?=App\Application::$HOST?>/admin/p/languages"><?php @include "../imgs/languages.svg";?>Languages</a></li>
            <li onclick="navigate(this)" data-page="settings" <?= (isset($_GET['p']) && @$_GET['p'] == 'settings')? 'class="active"':'';?>><a href="<?=App\Application::$HOST?>/admin/p/settings"><?php @include "../imgs/settings.svg";?>Settings</a></li>
        </ul>
    </nav>
    <main>
    <?php
        $application->checkPage();
        // include('includes/add-book.inc.php');
    ?>
    </main>
    <script src="<?=App\Application::$HOST?>/admin/js/script.js"></script>
</body>
</html>