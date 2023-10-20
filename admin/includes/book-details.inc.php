<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
@session_start();
$application = new App\Application;
$application->checkAdminLogin();
$category = new App\Category;
$writter = new App\Writter;
$bookId = $_GET['id'];
$book = new App\Book;
$bookDetails = $book->getById($bookId);
?>
<link rel="stylesheet" href="css/add-edit-book.css">
<header>
    <div class="left">
        <div class="title">Book Details</div>
    </div>
    <div class="right">
        <button id="back" onclick="back('books')">Back<?php include App\Application::$ROOT_DIR.'/imgs/back.svg'?></button>
        <button id="update" onclick="submitForm('book')" disabled>Update</button>
    </div>
</header>
<hr>
<section class="form-container">
    <form action="<?=App\Application::$HOST?>/controllers/update-book.controller.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$bookDetails['bookId']?>">
    <!-- SECTION - Cover photo and Pdf file -->
    <div class="inputes-wrapper files">
        <div class="input-container cover">
            <div class="input-name">Cover</div>
            <div class="input-wrapper" id="cover_img">
                <input type="file" id="cover"  accept=".jpg, .jpeg, .png" onchange="updateFormInput(this)">
                <div class="label">
                    <img src="<?=App\Application::$HOST?>/uploads/<?=$bookDetails['bookCover']?>">
                </div>
            </div>
        </div>
        <div class="input-container pdf">
            <div class="input-name">Pdf</div>
            <div class="input-wrapper" id="pdf_file">
                <input type="file" id="pdf" name="pdf"  accept=".pdf" onchange="updateFormInput(this)">
                <div class="label">
                    <iframe src="https://drive.google.com/file/d/<?=$bookDetails['bookPdf']?>/preview"></iframe>
                </div>
            </div>
        </div>
        <div class="input-container pdf-id">
            <div class="input-name">Pdf Id</div>
            <input type="tel" name="pdf_id" id="pdf_id" data-oldvalue="<?=$bookDetails['bookPdf'];?>" value="<?=$bookDetails['bookPdf']?>" onchange="updateFormInput(this)">
        </div>
    </div>
    <!-- SECTION - Name, Language, Writters, Catagory -->
    <div class="inputes-wrapper name">
        <div class="input-container name">
            <div class="input-name">Name</div>
            <input type="text" name="name" id="name" data-oldvalue="<?=$bookDetails['bookName'];?>" value="<?=$bookDetails['bookName']?>" onchange="updateFormInput(this)" required>
        </div>
        <div class="input-container name">
            <div class="input-name">Buying Link</div>
            <input type="text" data-oldvalue="<?=$bookDetails['bookBuyingLink'];?>" value="<?=$bookDetails['bookBuyingLink']?>" onchange="updateFormInput(this)" name="buyingLink" id="buyingLink">
        </div>
        <div class="input-container language">
            <div class="input-name">Language</div>
            <select name="language" data-oldvalue="<?=$bookDetails['bookLanguage'];?>" id="language" onchange="updateFormInput(this)" required>
                <option value="" style="display: none;">Language</option>
                <option value="Bangla" <?=($bookDetails['bookLanguage']=='Bangla')?'selected':'';?>>Bangla</option>
                <option value="English" <?=($bookDetails['bookLanguage']=='English')?'selected':'';?>>English</option>
            </select>
        </div>
        <div class="input-container writters">
            <div class="input-name">Writters</div>
            <div class="writters-container" onclick="document.getElementById('writters').focus();">
                <ul>
                    <?php
                        $writters = explode(',',$bookDetails['bookWritters']);
                        for($i = 0; $i < count($writters); $i++){
                            echo '<li>'.$writters[$i].'<img src="'.App\Application::$HOST.'/imgs/close.svg" onclick="removeWritter(this)"></li>';
                        }
                        
                    ?>
                    <input type="text" id="writters" onfocus="showWritters()" oninput="searchList(this,'writters')" autocomplete="off">
                </ul>
            </div>
            
            <div id="writtersDropdown">
                <ul>
                    <?=$writter->loadList($writters)?>
                </ul>
            </div>
            <input type="hidden" name="writters" id="test" data-oldvalue="<?=$bookDetails['bookWritters'];?>" value="<?=$bookDetails['bookWritters'];?>" onchange="updateFormInput(this)">
        </div>
        <div class="input-container category">
            <div class="input-name">Category</div>
            <input type="text" name="category" id="category" onfocus="showCategories()" oninput="searchList(this,'categories')" autocomplete="off" onchange="updateFormInput(this)" data-oldvalue="<?=$bookDetails['bookCategory']?>" value="<?=$bookDetails['bookCategory']?>"  required>
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
            <textarea name="description" id="description" cols="30" rows="10" data-oldvalue="<?=$bookDetails['bookDescription'];?>" onchange="updateFormInput(this)" required><?=$bookDetails['bookDescription']?></textarea>
        </div>
        <div class="input-container tags">
            <div class="input-name">Tags</div>
            <div class="tags-container" onclick="document.getElementById('tags').focus();">
                <ul>
                   
                <?php
                        $tags = explode(',',$bookDetails['bookTags']);
                        for($i = 0; $i < count($tags); $i++){
                            echo '<li>'.$tags[$i].'<img src="'.App\Application::$HOST.'/imgs/close.svg" onclick="removeTag(this)"></li>';
                        }
                        
                    ?>
                    <input id="tags" onkeyup="addTag(this, event)">
                </ul>   
            </div>
            <input type="hidden" name="tags" id="test2" data-oldvalue="<?=$bookDetails['bookTags']?>" value="<?=$bookDetails['bookTags']?>" onchange="updateFormInput(this)">
        </div>
    </div>
        
    </form>
</section>
<script>
    tags = <?=json_encode($tags)?>;
    writters = <?=json_encode($writters)?>;
</script>
<script src="js/add-edit-book.js"></script>