<?php
define('pageName', 'admin-settings');
use Core\Application;
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateAdminHead('Settings', pageName)?>
</head>
<body>
    <?=ResourceLoader::loadNotification()?>
    <?=ResourceLoader::loadComponent('admin-nav')?>
    <main>
    <header>
        <div class="left">
            <div class="title">Settings</div>
        </div>
        <div class="right">
            <button id="update" onclick="saveSettings()">Save</button>
        </div>
    </header>
    <hr>
    <section class="settings-container">
        <form action="<?=Application::$HOST?>/admin/save-settings" method="post">
            <div class="top">
                <div class="input-container">
                    <div class="input-name">Site Title</div>
                    <input type="text" name="title" id="title" data-old-value="<?=TITLE?>" value="<?=TITLE?>" required>
                </div>
            </div>
            <div class="bottom">
                <div class="input-container">
                    <div class="input-name">Site Description</div>
                    <textarea name="description" id="description" data-old-value="<?=DESCRIPTION?>" cols="30" rows="10" required><?=DESCRIPTION?></textarea>
                </div>
                <div class="input-container">
                    <div class="input-name">G Tags</div>
                    <textarea name="gtags" id="gtags" data-old-value="<?=GTAG?>" cols="30" rows="10" required><?=GTAG?></textarea>
                </div>
            </div>
        </form>
    </section>
    </main>
    <?=ResourceLoader::loadPageJs(pageName)?>
</body>
</html>