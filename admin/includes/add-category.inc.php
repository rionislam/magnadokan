<?php

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
@session_start();
$application = new App\Application;
$application->checkAdminLogin();
?>
<link rel="stylesheet" href="<?=App\Application::$HOST?>/admin/css/add-edit-catagory.css">
<header>
    <div class="left">
        <div class="title">Add new App\Category</div>
    </div>
    <div class="right">
        <button id="back" onclick="back('categories')">Back<?php include App\Application::$ROOT_DIR.'/imgs/back.svg'?></button>
        <button id="save" onclick="submitForm()">Save</button>
    </div>
</header>
<hr>
<section class="form-container">
    <form action="<?=App\Application::$HOST?>/controllers/add-category.controller.php" method="post" enctype="multipart/form-data">
        <div class="input-container icon">
            <div class="input-name">Icon</div>
            <div class="input-wrapper" id="icon_img">
                <input type="file" id="icon" name="icon"  accept=".jpg, .jpeg, .png" required>
                <div class="label">Select icon image</div>
            </div>
        </div>
        <div class="input-container category">
            <div class="input-name">Category Name</div>
            <input type="text" name="category" id="category" required>
        </div>
    </form>
</section>
<script src="<?=App\Application::$HOST?>/admin/js/add-edit-category.js"></script>