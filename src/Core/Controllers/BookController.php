<?php
namespace Core\Controllers;

use Core\Application;
use Core\Models\Book;
use Core\Services\ErrorHandler;
use Core\Utilities\Cache;
use Core\Services\HtmlGenerator;
use Core\Services\Search;
use Core\Utilities\DataConverter;
use Core\Utilities\Timer;
use DateTime;
use DateTimeZone;

class BookController extends Book{

    private $bookByName = NULL;

    public function loadUrlsForSitemap(){
        
        $booksCount = $this->count();
        $bookRows = $this->getLimited("0,{$booksCount}", '');
        $output = '';
        foreach($bookRows as $row){
            $encodedBookName = rawurlencode($row['bookName']);
            $date = new DateTime($row['bookUpdatedAt'], new DateTimeZone(date_default_timezone_get()));
            $date = $date->format('Y-m-d\TH:i:sP');
            $output .= "
            <url>
                <loc>".Application::$HOST."/book/{$encodedBookName}</loc>
                <lastmod>{$date}</lastmod>
                <priority>1</priority>
            </url>";
        }
        return $output;
    }

    public function loadPopularByLanguage($limit, $language){
        $rows = $this->getPopularByLanguage($limit, $language);
        foreach($rows as $row){
            $host = Application::$HOST;
            $encodedBookName = rawurlencode($row['bookName']);
            echo "<article class='slide' data-impression-collected=false data-book-category='{$row['bookCategory']}' data-book-id='{$row['bookId']}'>
                    <a draggable='false' href='{$host}/book/{$encodedBookName}' title='{$row['bookName']} by {$row['bookWritters']} Pdf Download'>
                    <div class='image-container'>
                    <img loading='lazy' onload='this.style.opacity = 1' alt='{$row['bookName']} by {$row['bookWritters']} Pdf Cover' src='uploads/books/covers/{$row['bookCover']}'>
                    </div>
                    <h3 class='name'>{$row['bookName']}</h3>
                    </a>
                </article>";
           
        }
    }

    public function getSeoTags($name){
        $row = $this->getByName($name);
        $this->bookByName = $row;
        $encodedBookName = rawurlencode($row['bookName']);
        $host = Application::$HOST;
        return "<meta property='og:title' content=\"{$row['bookName']} Free Pdf Download.\"/>
        <meta property='og:description' content=\"{$row['metaDescription']}\"/>
        <meta property='og:image' content='{$host}/uploads/books/covers/{$row['bookCover']}'/>
        <meta property='og:url' content='{$host}/book/{$name}'/>
        <meta property='og:type' content='book'/>
        <title>{$row['bookName']} | PDF Download - Magna Dokan</title>
        <meta name='description' content=\"{$row['metaDescription']}\"/>
        <meta name='keywords' content='{$row['bookTags']}'/>
        <link rel='canonical' href='{$host}/book/{$encodedBookName}'/>";
    }

    public function loadByName($name = NULL){
        if($name == NULL){
            $row = $this->bookByName;
        }else{
            $row = $this->getByName($name);
        }
        
        $logController = new LogController;
        $logController->collectBookLog('click', $row['bookId'], $row['bookCategory']);

        $host = Application::$HOST;

        $writters = '';
        $writtersArray = array_map('trim',explode(',', $row['bookWritters']));
        $userId = (isset($_SESSION['USER_ID'])) ? $_SESSION['USER_ID'] : '0';
        foreach($writtersArray  as $writter){
            $writters .= "<li><a href='#'>{$writter}</a></li>";
        }

        $suggestions = '';
        $relatedBooks = explode(',', $row['relatedBooks']);
        foreach($relatedBooks as $relatedBook){
            $book = $this->getById($relatedBook, 'bookName', 'bookCategory', 'bookWritters', 'bookCover');
            $encodedBookName = rawurlencode($book['bookName']);
            $suggestions .= "<article data-impression-collected=false data-book-category='{$book['bookCategory']}' data-book-id='{$relatedBook}'>
                                <a draggable='false' href='{$host}/book/{$encodedBookName}'>
                                    <div class='image-container'>
                                        <img loading='lazy' onload='this.style.opacity = 1' alt='{$book['bookName']} by {$book['bookWritters']} Pdf' src='uploads/books/covers/{$book['bookCover']}'>
                                    </div>
                                    <h3 class='name'>{$book['bookName']}</h3>
                                </a>
                            </article>";
        }
        
        $downloadIcon = file_get_contents(Application::$ROOT_DIR."/assets/images/icons/download.svg");
        $addToLibraryIcon = file_get_contents(Application::$ROOT_DIR."/assets/images/icons/library_add.svg");
        $addedToLibraryIcon = '<svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"><circle class="circle" cx="30" cy="30" r="30" fill="none"/><path class="check" fill="none" d="m12.5 28l10.0 13 24-22.2"/></svg>';
        $libraryButton = (isset($_COOKIE['LIBRARY_ADDED'])) ? $addedToLibraryIcon. "Added To Library" : $addToLibraryIcon."Add To Library";
        $cover = $host."/uploads/books/covers/{$row['bookCover']}";
        $decodedDescription = DataConverter::markdownToHtml($row['bookDescription']);
        return "<section class='book-container max-width center'>
                    <div class='left'>
                            <img src='{$cover}' alt='{$row['bookName']} by {$row['bookWritters']} Pdf Cover'>
                    </div>
                    <div class='right'>
                        <h1 class='title'>{$row['bookName']}</h1>
                        <div class='writters'>
                            <h2 class='title'>Writters:</h2>
                            <ul>
                                {$writters}
                            </ul>
                        </div>
                        <div class='vertical-ad-container'>
                            
                        </div>
                        <div class='bottom'>
                            <p class='notice'>Note: We always suggest to buy the real copy of the book. This patform is just for them who can't affort to buy.</p>
                            <button class='add-to-libray-btn' data-book-id='{$row['bookId']}' onclick='addToLibrary(this, {$userId})'>{$libraryButton}</button>
                            <button class='download-btn' onclick='download(this, {$userId})'>{$downloadIcon}<span>Download For Free.</span></button>
                        </div>
                        
                    </div>
                    <div class='mid'>
                        <div class='horizontal-ad-container'>
                            
                        </div>
                        <div class='description-container'>
                            <h2 class='title'>Description</h2>
                            <hr>
                            <p>{$decodedDescription}</p>
                            <button onclick='showMore(this)'>Show more...</button>
                        </div>
                        <div class='horizontal-ad-container'>
                           
                        </div>
                    </div>
                    <div class='bottom'>
                        <h2 class='title'>Related Books</h2>
                        <hr>
                        <div class='suggestions-container'>
                            {$suggestions}
                        </div>
                    </div>
                </section>
                ";   
    }

    public function loadForDownloadPageByName($name){
        $row = $this->getByName($name);
        $logController = new LogController;
        $logController->collectBookLog('download', $row['bookId'], $row['bookCategory']);
        return "<section class='book-container max-width center'>
                    <div class='left'>
                        <div class='image-container'>
                            <img loading='lazy' onload='this.style.opacity = 1' src='uploads/books/covers/{$row['bookCover']}' alt='{$row['bookName']} by {$row['bookWritters']} Pdf Cover'>
                        </div>
                    </div>
                    <div class='right'>
                        <h1 class='title'>{$row['bookName']}</h1>
                        <div class='download_text'>
                            <div class='download_text-container'>Downloading</div>
                        </div>
                    </div>
                </section>
                <script>
                    let bookPdf = '{$row['bookPdf']}';
                </script>";
    }

    public function loadByCategory($category, $page){
        if(!is_numeric($page)){
            ErrorHandler::displayErrorPage(404);
            exit;
        }
        $rows = NULL;
        $starting = 0 + 12 * ($page-1);
        $limit = 12;
        $category = rawurldecode($category);
        $condition = "WHERE `bookCategory`= '{$category}' ORDER BY `bookId` DESC";
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem("books?category={$category}&page={$page}");
        if(is_null($cacheInstance->get())){  
            $rows = $this->getLimited("{$starting},{$limit}", $condition);
            $cacheInstance->set($rows)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
        }else{
            $rows = $cacheInstance->get();
        }

        $books = '';
        if(is_array($rows)){
            $host = Application::$HOST;
            foreach($rows as $row){
                $host = Application::$HOST;
                $link = Application::$HOST.'/book/'.rawurlencode($row['bookName']);
                $books .= "<article data-impression-collected=false data-book-category='{$row['bookCategory']}' data-book-id='{$row['bookId']}'>
                            <a href='{$link}' title='{$row['bookName']} by {$row['bookWritters']} Pdf Download'>
                            <div class='image-container'>
                                <img loading='lazy' onload='this.style.opacity = 1' src='uploads/books/covers/{$row['bookCover']}' alt='{$row['bookName']} by {$row['bookWritters']} Pdf Cover'>
                            </div>
                            <h3 class='name'>{$row["bookName"]}</h3>
                            </a></article>";
            }
        }else{
            $books .= 'Nothing found!';
        }
        $bookCount = $this->count($condition);
        $htmlGenerator = new HtmlGenerator;

        return "<section class='books max-width center'>
                <header>
                    <div class='title'>{$category} books.</div>
                    <div class='short-by'>
                        <label for='short-by'>Short by:</label>
                        <select name='short-by' id='short-by'>
                            <option value='latest' selected>Latest</option>
                            <option value='Popularity'>Popularity</option>
                        </select>
                    </div>
                </header>
                <hr>
                <div class='books-container'>
                {$books}
                </div>
                {$htmlGenerator->generatePagination(12, $bookCount, $page, Application::$HOST."/books/category/{$category}/{page}")}
                </section>";
        
    }

    public function loadByKeyword($keyword, $page){
        if(!is_numeric($page)){
            ErrorHandler::displayErrorPage(404);
            exit;
        }
        $rows = NULL;
        $starting = 0 + 12 * ($page-1);
        $limit = 12;
        $keyword = rawurldecode($keyword);
        $search = new Search;
        $condition = $search->createCondition($keyword);
        $order = $search->createOrder($keyword);
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem("books?keyword={$keyword}&page={$page}");
        if(is_null($cacheInstance->get())){  
            $rows = $this->getLimited("{$starting},{$limit}", $condition . $order);
            $cacheInstance->set($rows)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
        }else{
            $rows = $cacheInstance->get();
        }

        $books = '';
        if(is_array($rows)){
            $host = Application::$HOST;
            foreach($rows as $row){
                $host = Application::$HOST;
                $link = Application::$HOST.'/book/'.rawurlencode($row['bookName']);
                $books .= "<article data-impression-collected=false data-book-category='{$row['bookCategory']}' data-book-id='{$row['bookId']}'>
                            <a href='{$link}' title='{$row['bookName']} by {$row['bookWritters']} Pdf Download'>
                            <div class='image-container'>
                                <img loading='lazy' onload='this.style.opacity = 1' src='uploads/books/covers/{$row['bookCover']}' alt='{$row['bookName']} by {$row['bookWritters']} Pdf Cover'>
                            </div>
                            <h3 class='name'>{$row["bookName"]}</h3>
                            </a></article>";
            }
        }else{
            $books .= 'Nothing found!';
        }
        $bookCount = $this->count($condition);
        $htmlGenerator = new HtmlGenerator;

        return "<section class='books max-width center'>
                <header>
                    <div class='title'>Search result for {$keyword}</div>
                    <div class='short-by'>
                        <label for='short-by'>Short by:</label>
                        <select name='short-by' id='short-by'>
                            <option value='latest' selected>Latest</option>
                            <option value='Popularity'>Popularity</option>
                        </select>
                    </div>
                </header>
                <hr>
                <div class='books-container'>
                {$books}
                </div>
                {$htmlGenerator->generatePagination(12, $bookCount, $page, Application::$HOST."/search/{$keyword}/{page}")}
                </section>";
    }

    public function loadByLanguage($language, $page){
        if(!is_numeric($page)){
            ErrorHandler::displayErrorPage(404);
            exit;
        }
        $rows = NULL;
        $starting = 0 + 12 * ($page-1);
        $limit = 12;
        $condition = "WHERE `bookLanguage`= '{$language}' ORDER BY `bookId` DESC";
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem("books?language={$language}&page={$page}");
        if(is_null($cacheInstance->get())){  
            $rows = $this->getLimited("{$starting},{$limit}", $condition);
            $cacheInstance->set($rows)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
        }else{
            $rows = $cacheInstance->get();
        }

        $books = '';
        if(is_array($rows)){
            foreach($rows as $row){
                $link = Application::$HOST.'/book/'.rawurlencode($row['bookName']);
                $books .= "<article data-impression-collected=false data-book-category='{$row['bookCategory']}' data-book-id='{$row['bookId']}'>
                            <a href='{$link}' title='{$row['bookName']} by {$row['bookWritters']} Pdf Download'>
                            <div class='image-container'>
                                <img loading='lazy' onload='this.style.opacity = 1' src='uploads/books/covers/{$row['bookCover']}' alt='{$row['bookName']} by {$row['bookWritters']} Pdf Cover'>
                            </div>
                            <h3 class='name'>{$row["bookName"]}</h3>
                            </a></article>";
            }
        }else{
            $books .= 'Nothing found!';
        }
        $bookCount = $this->count($condition);
        $htmlGenerator = new HtmlGenerator;

        return "<section class='books max-width center'>
                <header>
                    <div class='title'>{$language} books.</div>
                    <div class='short-by'>
                        <label for='short-by'>Short by:</label>
                        <select name='short-by' id='short-by'>
                            <option value='latest' selected>Latest</option>
                            <option value='Popularity'>Popularity</option>
                        </select>
                    </div>
                </header>
                <hr>
                <div class='books-container'>
                {$books}
                </div>
                {$htmlGenerator->generatePagination(12, $bookCount, $page, Application::$HOST."/books/language/{$language}/{page}")}
                </section>";
        
    }

    public function loadAll($page){
        if(!is_numeric($page)){
            ErrorHandler::displayErrorPage(404);
            exit;
        }
        $rows = NULL;
        $starting = 0 + 12 * ($page-1);
        $limit = 12;
        $condition = "";
        $cache = new Cache;
        $cache = $cache->config();
        $cacheInstance = $cache->getItem("books?page={$page}");
        if(is_null($cacheInstance->get())){  
            $rows = $this->getLimited("{$starting},{$limit}", $condition);
            $cacheInstance->set($rows)->expiresAfter(Timer::timeLeftForNextDay());
            $cache->save($cacheInstance);
        }else{
            $rows = $cacheInstance->get();
        }

        $books = "";
        if(is_array($rows)){
            $host = Application::$HOST;
            foreach($rows as $row){
                $host = Application::$HOST;
                $link = Application::$HOST.'/book/'.rawurlencode($row['bookName']);
                $books .= "<article data-impression-collected=false data-book-category='{$row['bookCategory']}' data-book-id='{$row['bookId']}'>
                            <a href='{$link}' title='{$row['bookName']} by {$row['bookWritters']} Pdf Download'>
                            <div class='image-container'>
                                <img loading='lazy' onload='this.style.opacity = 1' src='uploads/books/covers/{$row['bookCover']}' alt='{$row['bookName']} by {$row['bookWritters']} Pdf Cover'>
                            </div>
                            <h3 class='name'>{$row["bookName"]}</h3>
                            </a></article>";
            }
        }else{
            $books .= 'Nothing found!';
        }
        $bookCount = $this->count($condition);
        $htmlGenerator = new HtmlGenerator;

        return "<section class='books max-width center'>
                <header>
                    <div class='title'>All books.</div>
                    <div class='short-by'>
                        <label for='short-by'>Short by:</label>
                        <select name='short-by' id='short-by'>
                            <option value='latest' selected>Latest</option>
                            <option value='Popularity'>Popularity</option>
                        </select>
                    </div>
                </header>
                <hr>
                <div class='books-container'>
                {$books}
                </div>
                {$htmlGenerator->generatePagination(12, $bookCount, $page, Application::$HOST."/books/{page}")}
                </section>";
        
    }

    public function processBookRequest(){
      
        $name = $_POST['bookName'];
        $writters = $_POST['bookWritters'];
        $publication = $_POST['publication'];
        $note = $_POST['note'];

        if($this->request($_SESSION['USER_ID'], $name, $writters, $publication, $note) !== false){
            $_SESSION['NOTIFICATION'] = true;
            $_SESSION['NOTIFICATION_MESSAGE'] = 'Book request submited successfully!';
            header("Location: ".Application::$HOST);
        };

    }
}

