<?php
define('pageName', 'admin-books');
use Core\Application;
use Core\Controllers\AdminCategoryController;
use Core\Controllers\AdminWritterController;
use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateAdminHead('Add Book', pageName)?>
</head>
<body>
    <?=ResourceLoader::loadNotification()?>
    <?=ResourceLoader::loadComponent('admin-nav')?>
<main>
<header>
    <div class="left">
        <div class="title">Add new Book</div>
    </div>
    <div class="right">
        <button id="back" onclick="back('books')">Back<?=ResourceLoader::loadIcon('back.svg')?></button>
        <button id="save" onclick="addBook()">Save</button>
    </div>
</header>
<hr>
<section class="form-container">
    <form action="<?=Application::$HOST?>/admin/process-add-book" method="post" enctype="multipart/form-data">
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
                <input type="file" id="pdf" name="pdf"  accept=".pdf" disabled>
                <div class="label">Select the pdf</div>
            </div>
        </div>
        
    </div>
    <!-- SECTION - Name, Language, Writters, Catagory -->
    <div class="inputes-wrapper name">
        <div class="input-container name">
            <div class="input-name">Name</div>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="input-container pdf-id">
            <div class="input-name">Pdf Id</div>
            <input type="tel" name="pdfId" id="pdfId" required>
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
                    <?php
                        $adminWritterController = new AdminWritterController;
                        echo $adminWritterController->loadAllWrittersName();
                    ?>
                </ul>
            </div>
            <input type="hidden" name="writters">
        </div>
        <div class="input-container category">
            <div class="input-name">Category</div>
            <input type="text" name="category" id="category" onfocus="showCategories()" oninput="searchList(this,'categories')" autocomplete="off" required>
            <div id="categoriesDropdown">
                <ul>
                    <?php
                    $adminCategoryController = new AdminCategoryController;
                    echo $adminCategoryController->loadAllCategoriesName();
                    
                    ?>
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
            <div class="tags-container" onclick="document.getElementById('tagInput').focus();">
                <ul>
                    <input id="tagInput">
                </ul>   
            </div>
            <input type="hidden" name="tags">
        </div>
    </div>
        
    </form>
</section>
</main>

<?=ResourceLoader::loadPageJs(pageName)?>
</body>
</html>