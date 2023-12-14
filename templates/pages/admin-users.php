<?php
define('pageName', 'admin-users');
use Core\Application;
use Core\Controllers\AdminUserController;
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateAdminHead('Users', pageName)?>
</head>
<body>
    <?=ResourceLoader::loadComponent('admin-nav')?>
    <main>
    <header>
        <div class="left">
            <div class="title">Users</div>
        </div>
        <div class="right">
            <form class="search-bar" action="" method="post">
                <input type="text" id="search" name="search" placeholder="Search here...">
                <input type="image" src="<?=Application::$HOST?>/assets/images/icons/search.svg">
            </form>
        </div>
    </header>
    <hr>
    <section class="user-container">
        <div class="row header-row">
            <div class="user-name">Username</div>
            <div class="user-full-name">Full Name</div>
            <div class="user-email">Email</div>
            <div class="user-status">Status</div>
        </div>
        <hr>
        <div class="rows-container">
            <?php
            $adminUserController = new AdminUserController;
            $adminUserController->loadAll();
            ?>
        </div>
    </section>
    </main>
</body>
</html>