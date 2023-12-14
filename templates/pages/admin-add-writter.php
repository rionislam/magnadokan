<?php
define('pageName', 'admin-writters');
use Core\Application;
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateAdminHead('Add Writter', pageName)?>
</head>
<body>
    <?=ResourceLoader::loadNotification()?>
    <?=ResourceLoader::loadComponent('admin-nav')?>
<main>
<header>
    <div class="left">
        <div class="title">Add new writter</div>
    </div>
    <div class="right">
        <button id="back" onclick="back('writters')">Back<?=ResourceLoader::loadIcon('back.svg')?></button>
        <button id="save" onclick="addWritter()">Save</button>
    </div>
</header>
<hr>
<section class="form-container">
    <form action="<?=Application::$HOST?>/admin/process-add-writter" method="post" enctype="multipart/form-data">
        <div class="input-container icon">
            <div class="input-name">Icon</div>
            <div class="input-wrapper" id="icon_img">
                <input type="file" id="icon"  accept=".jpg, .jpeg, .png" required>
                <div class="label">Select icon image</div>
            </div>
        </div>
        <div class="input-container writter">
            <div class="input-name">Writter Name</div>
            <input type="text" name="writterName" required>
        </div>
    </form>
</section>
</main>
<?=ResourceLoader::loadPageJs(pageName)?>
</body>
</html>