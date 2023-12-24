<?php
define('pageName', 'admin-languages');

use Core\Application;
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateAdminHead('Languages', pageName)?>
</head>
<body>
<?=ResourceLoader::loadComponent('admin-nav')?>
<main>
<header>
    <div class="left">
        <div class="title">Languages</div>
    </div>
    <div class="right">
        <form class="search-bar" action="" method="post">
            <input type="text" id="search" name="search" placeholder="Search here...">
            <input type="image" src="<?=Application::$HOST?>/assets/images/icons/search.svg">
        </form>
        <button id="addNewBtn" onclick="addNew('book')">Add New</button>
    </div>
</header>
<hr>
<!-- This page is currently not working cause we are just working with two languages -->
</main>
</body>
</html>