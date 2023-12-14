<?php
namespace Core\Controllers;

use Core\Application;
use Core\Models\Book;
use Core\Models\Writter;
use Core\Services\FileHandler;
use Core\Services\ErrorHandler;
use Core\Services\ResourceLoader;
use Core\Services\AdminAuthHandler;

class AdminBookController extends Book{
    public function loadAll(){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $rows = $this->getAll();
        if($rows !== false){
            $detailsLogo = ResourceLoader::loadIcon('details.svg');
            foreach($rows as $row){
                echo "<div class='row' onclick='this.getElementsByTagName(\"a\")[0].click();'>
                    <div class='name'>".$row['bookName']."</div>
                    <div class='writter'>".$row['bookWritters']."</div>
                    <div class='downloads'>".$row['downloads']."</div>
                    <div class='clicks'>".$row['clicks']."</div>
                    <a href='".Application::$HOST."/admin/book-details/".$row['bookId']."' class='details'>$detailsLogo</a>
                    </div>";
            }
        }else{
            echo 'Nothing found!';
        }
    }

    public function showBookDetails($id){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $row = $this->getById($id);
        $host = Application::$HOST;
        $writterModel = new Writter;
        $writters = $writterModel->getAllWrittersName();
        $bookWritters = NULL;
        $bookWrittersJson = array();
        
        if($row['bookWritters'] != NULL && $writters != NULL){
            $bookWritters = array_map('trim',explode(',',$row['bookWritters']));
            $bookWrittersJson = json_encode($bookWritters);
        }
        $adminWritterController = new AdminWritterController;
        $writtersDropdown = $adminWritterController->loadAllWrittersName($bookWritters);

        $writtersInput = "";
        if($bookWritters != NULL){
            foreach($bookWritters as $bookWritter){
                $writtersInput .= "<li>{$bookWritter}<img src='{$host}/assets/images/icons/close.svg' onclick='removeWritter(this)'></li>";
            }
        }

        $adminCategoryController = new AdminCategoryController;
        $categoriesDropdown = $adminCategoryController->loadAllCategoriesName($row['bookCategory']);
        
        
        $bookTags = explode(',', $row['bookTags']);
        $bookTagsJson = json_encode($bookTags);
        $tagsInput = "";
        if($bookTags != NULL){
            foreach($bookTags as $bookTag){
                $tagsInput .= "<li>{$bookTag}<img src='{$host}/assets/images/icons/close.svg' onclick='removeTag(this)'></li>";
            }
        }


        return "<input type='hidden' name='id' value='{$row['bookId']}'>
        <!-- SECTION - Cover photo and Pdf file -->
        <div class='inputes-wrapper files'>
            <div class='input-container cover'>
                <div class='input-name'>Cover</div>
                <div class='input-wrapper' id='cover_img'>
                    <input type='file' id='cover'  accept='.jpg, .jpeg, .png' onchange='updateFormInput(this)'>
                    <div class='label'>
                        <img src='{$host}/uploads/books/covers/{$row['bookCover']}'>
                    </div>
                </div>
            </div>
            <div class='input-container pdf'>
                <div class='input-name'>Pdf</div>
                <div class='input-wrapper' id='pdf_file'>
                    <input type='file' id='pdf' name='pdf'  accept='.pdf' onchange='updateFormInput(this)'>
                    <div class='label'>
                        <iframe src='https://drive.google.com/file/d/{$row['bookPdf']}/preview'></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- SECTION - Name, Language, Writters, Catagory -->
        <div class='inputes-wrapper name'>
            <div class='input-container name'>
                <div class='input-name'>Name</div>
                <input type='text' name='name' id='name' data-oldvalue='{$row['bookName']}' value='{$row['bookName']}' onchange='updateFormInput(this)' required>
            </div>
            <div class='input-container pdf-id'>
                <div class='input-name'>Pdf Id</div>
                <input type='tel' name='pdfId' id='pdfId' data-oldvalue='{$row['bookPdf']}' value='{$row['bookPdf']}' onchange='updateFormInput(this)' required>
            </div>
            <div class='input-container language'>
                <div class='input-name'>Language</div>
                <select name='language' data-oldvalue='{$row['bookLanguage']}' id='language' onchange='updateFormInput(this)' required>
                    <option value='' style='display: none;'>Language</option>
                    <option value='Bangla' ".(($row['bookLanguage'] == 'Bangla') ? 'selected' : '').">Bangla</option>
                    <option value='English' ".(($row['bookLanguage'] == 'English')? 'selected' : '').">English</option>
                </select>
            </div>
            <div class='input-container writters'>
                <div class='input-name'>Writters</div>
                <div class='writters-container' onclick='document.getElementById(\"writters\").focus();'>
                    <ul>
                        {$writtersInput}
                        <input type='text' id='writters' onfocus='showWritters()' oninput=\"searchList(this,'writters')\" autocomplete='off'>
                    </ul>
                </div>
                
                <div id='writtersDropdown'>
                    <ul>
                        {$writtersDropdown}
                    </ul>
                </div>
                <input type='hidden' name='writters' data-oldvalue='{$row['bookWritters']}' value='{$row['bookWritters']}' onchange='updateFormInput(this)'>
            </div>
            <div class='input-container category'>
                <div class='input-name'>Category</div>
                <input type='text' name='category' id='category' onfocus='showCategories()' oninput=\"searchList(this,'categories')\" autocomplete='off' onchange='updateFormInput(this)' data-oldvalue='{$row['bookCategory']}' value='{$row['bookCategory']}'  required>
                <div id='categoriesDropdown'>
                    <ul>
                        {$categoriesDropdown}
                    </ul>
                </div>
            </div>
        </div>
        <!-- SECTION - Description and tag -->
        <div class='inputes-wrapper description'>
            <div class='input-container description'>
                <div class='input-name'>Description</div>
                <textarea name='description' id='description' cols='30' rows='10' data-oldvalue=\"{$row['bookDescription']}\" onchange='updateFormInput(this)' required>{$row['bookDescription']}</textarea>
            </div>
            <div class='input-container tags'>
                <div class='input-name'>Tags</div>
                <div class='tags-container' onclick=\"document.getElementById('tagInput').focus();\">
                    <ul>
                       {$tagsInput}
                        <input id='tagInput'>
                    </ul>   
                </div>
                <input type='hidden' name='tags' data-oldvalue='{$row['bookTags']}' value='{$row['bookTags']}' onchange='updateFormInput(this)'>
                <script>
                    window.tagsArray = {$bookTagsJson};
                    window.writters = {$bookWrittersJson};
                    writters = window.writters;
                </script>
            </div>
        </div>
        ";
    }

    public function addBook(){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $cover = htmlspecialchars($_POST['cover'], ENT_QUOTES, 'UTF-8');;
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $pdfId = htmlspecialchars($_POST['pdfId'], ENT_QUOTES, 'UTF-8');
        $language = htmlspecialchars($_POST['language'], ENT_QUOTES, 'UTF-8');
        $writters = htmlspecialchars($_POST['writters'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
        $tags = htmlspecialchars($_POST['tags'], ENT_QUOTES, 'UTF-8');
        $category = htmlspecialchars($_POST['category'], ENT_QUOTES, 'UTF-8');
        if(empty($cover) || empty($name) || empty($pdfId) || empty($language) || empty($writters) || empty($description) || empty($tags) || empty($category)){
            header("Location: ".Application::$HOST."/admin");
            exit();
        }

        $response = $this->add($name, $pdfId, $language, $writters, $description, $tags, $cover, $category);
        if($response != false){
            $_SESSION['NOTIFICATION'] = true;
            $_SESSION['NOTIFICATION_MESSAGE'] = "The book is successfully added.";
            $fileHandler = new FileHandler;
            $fileHandler->use($cover);
            header("Location: ".Application::$HOST."/admin/books");
        }else{
            $_SESSION['ERROR'] = true;
            $_SESSION['ERROR_MESSAGE'] = "There is an error. Please try again later!";
            header("Location: ".Application::$HOST."/admin/add-book");
        }
    }

    public function updateBook(){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $bookId = $_POST['id'];
        if(isset($_POST['name'])){
            if(!$this->update($bookId, 'bookName', htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'))){
                $_SESSION['ERROR'] = true;
                $_SESSION['ERROR_MESSAGE'] = "There was an error. Please try again later!";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
        }

        if(isset($_POST['cover'])){
            if(!$this->update($bookId, 'bookCover', htmlspecialchars($_POST['cover'], ENT_QUOTES, 'UTF-8'))){
                $_SESSION['ERROR'] = true;
                $_SESSION['ERROR_MESSAGE'] = "There was an error. Please try again later!";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
            ;
        }

        if(isset($_POST['pdfId'])){
            if($this->update($bookId, 'bookPdf', htmlspecialchars($_POST['pdfId'], ENT_QUOTES, 'UTF-8'))){
                $_SESSION['ERROR'] = true;
                $_SESSION['ERROR_MESSAGE'] = "There was an error. Please try again later!";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
            
        }

        if(isset($_POST['language'])){
            if(!$this->update($bookId, 'bookLanguage', htmlspecialchars($_POST['language'], ENT_QUOTES, 'UTF-8'))){
                $_SESSION['ERROR'] = true;
                $_SESSION['ERROR_MESSAGE'] = "There was an error. Please try again later!";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
        }

        if(isset($_POST['writters'])){
            if(!$this->update($bookId, 'bookWritters', htmlspecialchars($_POST['writters']), ENT_QUOTES, 'UTF-8')){
                $_SESSION['ERROR'] = true;
                $_SESSION['ERROR_MESSAGE'] = "There was an error. Please try again later!";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
        }

        if(isset($_POST['category'])){
            if(!$this->update($bookId, 'bookCategory', htmlspecialchars($_POST['category'], ENT_QUOTES, 'UTF-8'))){
                $_SESSION['ERROR'] = true;
                $_SESSION['ERROR_MESSAGE'] = "There was an error. Please try again later!";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
        }

        if(isset($_POST['description'])){
            if(!$this->update($bookId, 'bookDescription', htmlspecialchars($_POST['description']), ENT_QUOTES, 'UTF-8')){
                $_SESSION['ERROR'] = true;
                $_SESSION['ERROR_MESSAGE'] = "There was an error. Please try again later!";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
        }

        if(isset($_POST['tags'])){
            if(!$this->update($bookId, 'bookTags', htmlspecialchars($_POST['tags']), ENT_QUOTES, 'UTF-8')){
                $_SESSION['ERROR'] = true;
                $_SESSION['ERROR_MESSAGE'] = "There was an error. Please try again later!";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
        }

        $_SESSION['NOTIFICATION'] = true;
        $_SESSION['NOTIFICATION_MESSAGE'] = "The book is successfully updated.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
}