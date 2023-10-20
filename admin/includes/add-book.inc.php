<?php

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
@session_start();
$application = new App\Application;
$application->checkAdminLogin();
$category = new App\Category;
$writter = new App\Writter;
?>
<link rel="stylesheet" href="css/add-edit-book.css">
<header>
    <div class="left">
        <div class="title">Add new App\Book</div>
    </div>
    <div class="right">
        <button id="back" onclick="back('books')">Back<?php include App\Application::$ROOT_DIR.'/imgs/back.svg'?></button>
        <button id="save" onclick="submitForm('book')">Save</button>
    </div>
</header>
<hr>
<section class="form-container">
    <form action="<?=App\Application::$HOST?>/controllers/add-book.controller.php" method="post" enctype="multipart/form-data">
    <!-- SECTION - Cover photo and Pdf file -->
    <div class="inputes-wrapper files">
        <div class="input-container cover">
            <div class="input-name">Cover</div>
            <div class="input-wrapper" id="cover_img">
                <input type="file" id="cover"  accept=".jpg, .jpeg, .png" required>
                <div class="label">Select cover image</div>
            </div>
        </div>
        <div class="input-container pdf">
            <div class="input-name">Pdf</div>
            <div class="input-wrapper" id="pdf_file">
                <input type="file" id="pdf" name="pdf"  accept=".pdf">
                <div class="label">Select the pdf</div>
            </div>
        </div>
        <div class="input-container pdf-id">
            <div class="input-name">Pdf Id</div>
            <input type="tel" name="pdf_id" id="pdf_id">
        </div>
    </div>
    <!-- SECTION - Name, Language, Writters, Catagory -->
    <div class="inputes-wrapper name">
        <div class="input-container name">
            <div class="input-name">Name</div>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="input-container name">
            <div class="input-name">Buying Link</div>
            <input type="text" name="buyingLink" id="buyingLink">
        </div>
        <div class="input-container language">
            <div class="input-name">Language</div>
            <select name="language" id="language" required>
                <option value="" style="display: none;">Language</option>
                <option value="Bangla">Bangla</option>
                <option value="English">English</option>
            </select>
        </div>
        <div class="input-container writters">
            <div class="input-name">Writters</div>
            <div class="writters-container" onclick="document.getElementById('writters').focus();">
                <ul>
                    <input type="text" id="writters" onfocus="showWritters()" oninput="searchList(this,'writters')" autocomplete="off">
                </ul>
            </div>
            
            <div id="writtersDropdown">
                <ul>
                    <?=$writter->loadList()?>
                </ul>
            </div>
            <input type="hidden" name="writters">
        </div>
        <div class="input-container category">
            <div class="input-name">Category</div>
            <input type="text" name="category" id="category" onfocus="showCategories()" oninput="searchList(this,'categories')" autocomplete="off" required>
            <div id="categoriesDropdown">
                <ul>
                    <?=$category->loadList()?>
                </ul>
            </div>
        </div>
    </div>
    <!-- SECTION - Description and tag -->
    <div class="inputes-wrapper description">
        <div class="input-container description">
            <div class="input-name">Description</div>
            <textarea name="description" id="description" cols="30" rows="10" required></textarea>
        </div>
        <div class="input-container tags">
            <div class="input-name">Tags</div>
            <div class="tags-container" onclick="document.getElementById('tags').focus();">
                <ul>
                    <input id="tags" onkeyup="addTag(this, event)">
                </ul>   
            </div>
            <input type="hidden" name="tags">
        </div>
    </div>
        
    </form>
</section>
<script src="js/add-edit-book.js"></script>