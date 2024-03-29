<?php
namespace Core\Controllers;

use Core\Application;
use Core\Models\Book;
use Core\Models\Writter;
use Core\Services\FileHandler;
use Core\Services\ErrorHandler;
use Core\Services\ResourceLoader;
use Core\Services\AdminAuthHandler;
use Core\Services\HtmlGenerator;
use Core\Services\Search;
use Core\Utilities\Cache;
use Core\Utilities\Timer;

class AdminBookController extends Book{
    // NOTE - Comparing 30 days
    public function booksIncreased(){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $increased = 0;
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem('booksIncreased');
        if(is_null($cacheInstance->get())){
            $addedThisMonth = $this->getRows("SELECT COUNT(*) AS count FROM books WHERE DATE(bookAddedAt) < DATE(NOW()) AND DATE(bookAddedAt) > DATE(NOW() - INTERVAL 30 DAY);")[0]['count'];
            $addedPreviousMonth = $this->getRows("SELECT COUNT(*) AS count FROM books WHERE DATE(bookAddedAt) < DATE(NOW() - INTERVAL 30 DAY) AND DATE(bookAddedAt) > DATE(NOW() - INTERVAL 60 DAY);")[0]['count'];
            if ($addedPreviousMonth != 0) {
                $increased = floor((($addedThisMonth - $addedPreviousMonth) / $addedPreviousMonth) * 100);
            } else {
                // Handle the case where addedPreviousMonth is 0 to avoid division by zero
                $increased = 100;
            }
            $cacheInstance->set($increased)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
        }else{
            $increased = $cacheInstance->get();
        }
    

        return $increased;
    }


    public function loadPopularBooks(){
        $rows = $this->getPopular('0,5');
        $books = NULL;
        if(count($rows)>0){
            foreach($rows as $row){
                $cover = Application::$HOST."/uploads/books/covers/".$row['bookCover'];
                $books .= "<div class='top_book'>
                                <div class='top_book-cover'>
                                    <img src='{$cover}'>
                                </div>
                                <div class='top_book-name'>{$row['bookName']}</div>
                                <div class='top_book-impressions'>{$row['clicks']}</div>
                                <div class='top_book-downloads'>{$row['downloads']}</div>
                            </div>";
               
            }
        }else{
            $books = 'No Data!';
        }
        
        return $books;
    }

    public function loadAll($page){
        if(!AdminAuthHandler::isLoggedIn()){
            ErrorHandler::displayErrorPage(403);
            exit;
        }
        $rows = NULL;
        $starting = 0 + 20 * ($page-1);
        $limit = 20;
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem("admin-books?page={$page}");
        if(is_null($cacheInstance->get())){  
            $sql = "SELECT
                        b.bookName, b.bookWritters, b.bookId,
                        COALESCE(SUM(CASE 
                                        WHEN bl.event = 'download' THEN 1
                                        ELSE 0 END), 0) AS downloads,
                        COALESCE(SUM(CASE 
                                        WHEN bl.event = 'click' THEN 1
                                        ELSE 0 END), 0) AS clicks
                    FROM
                        books b
                    LEFT JOIN
                        bookLogs bl ON b.bookId = bl.bookId
                    GROUP BY
                        b.bookId
                    ORDER BY
                        b.bookId DESC
                    LIMIT
                       {$starting},{$limit};";
            $rows = $this->getRows($sql);
            $cacheInstance->set($rows)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
        }else{
            $rows = $cacheInstance->get();
        }

        $books = "";
        if(is_array($rows)){
            $detailsLogo = ResourceLoader::loadIcon('details.svg');
            foreach($rows as $row){
                $link = Application::$HOST."/admin/book-details/".$row['bookId'];
                $books .= "<div class='row' onclick='this.getElementsByTagName(\"a\")[0].click();'>
                <div class='name'>{$row['bookName']}</div>
                <div class='writter'>{$row['bookWritters']}</div>
                <div class='downloads'>{$row['downloads']}</div>
                <div class='clicks'>{$row['clicks']}</div>
                <a href='{$link}' class='details'>$detailsLogo</a>
                </div>";
            }
        }else{
            $books .= 'Nothing found!';
        }
        $bookCount = $this->count();
        $htmlGenerator = new HtmlGenerator;

        return "<section class='books-container'>
                <div class='row header-row'>
                    <div class='name'>Name</div>
                    <div class='writter'>Writter</div>
                    <div class='downloads'>Downloads</div>
                    <div class='clicks'>Clicks</div>
                    <div class='details'>Details</div>
                </div>
                <hr>
                <div class='rows-container'>
                <div class='books-container'>
                {$books}
                </div>
                {$htmlGenerator->generatePagination(20, $bookCount, $page, Application::$HOST."/admin/books/{page}")}
                </section>";
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

    public function searchBooks(){
        $keyword = $_POST['keyword'];
        $rows = NULL;
        $starting = 0;
        $limit = 12;
        $keyword = rawurldecode($keyword);
        $search = new Search;
        $condition = $search->createCondition($keyword);
        $order = $search->createOrder($keyword);
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem("admin-books?keyword={$keyword}");
        if(is_null($cacheInstance->get())){  
            $sql = "SELECT
                        b.bookName, b.bookWritters, b.bookId,
                        COALESCE(SUM(CASE 
                                        WHEN bl.event = 'download' THEN 1
                                        ELSE 0 END), 0) AS downloads,
                        COALESCE(SUM(CASE 
                                        WHEN bl.event = 'click' THEN 1
                                        ELSE 0 END), 0) AS clicks
                    FROM
                        books b
                    LEFT JOIN
                        bookLogs bl ON b.bookId = bl.bookId
                    {$condition}
                    GROUP BY
                        b.bookId
                     {$order}
                    LIMIT
                       {$starting},{$limit};";
            $rows = $this->getRows($sql);
            $cacheInstance->set($rows)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
        }else{
            $rows = $cacheInstance->get();
        }

        $books = "";
        if(is_array($rows)){
            $detailsLogo = ResourceLoader::loadIcon('details.svg');
            foreach($rows as $row){
                $link = Application::$HOST."/admin/book-details/".$row['bookId'];
                $books .= "<div class='row' onclick='this.getElementsByTagName(\"a\")[0].click();'>
                <div class='name'>{$row['bookName']}</div>
                <div class='writter'>{$row['bookWritters']}</div>
                <div class='downloads'>{$row['downloads']}</div>
                <div class='clicks'>{$row['clicks']}</div>
                <a href='{$link}' class='details'>$detailsLogo</a>
                </div>";
            }
        }else{
            $books .= 'Nothing found!';
        }
        echo $books;
    }
}