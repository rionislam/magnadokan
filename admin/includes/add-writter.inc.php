<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
@session_start();
$application = new App\Application;
$application->checkAdminLogin();
?>
<link rel="stylesheet" href="<?=App\Application::$HOST?>/admin/css/add-edit-writter.css">
<header>
    <div class="left">
        <div class="title">Add new App\Writter</div>
    </div>
    <div class="right">
        <button id="back" onclick="back('writters')">Back<?php include App\Application::$ROOT_DIR.'/imgs/back.svg'?></button>
        <button id="save" onclick="submitForm()">Save</button>
    </div>
</header>
<hr>
<section class="form-container">
    <form action="<?=App\Application::$HOST?>/controllers/add-writter.controller.php" method="post" enctype="multipart/form-data">
        <div class="input-container icon">
            <div class="input-name">Icon</div>
            <div class="input-wrapper" id="icon_img">
                <input type="file" id="icon" name="file"  accept=".jpg, .jpeg, .png" required>
                <div class="label">Select icon image</div>
            </div>
        </div>
        <div class="input-container writter">
            <div class="input-name">Writter Name</div>
            <input type="text" name="writter-name" id="writter-name" required>
        </div>
    </form>
</section>
<script src="<?=App\Application::$HOST?>/admin/js/add-edit-writter.js"></script>