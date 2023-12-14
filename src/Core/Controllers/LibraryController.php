<?php
namespace Core\Controllers;

use Core\Application;
use Core\Models\Book;
use Core\Models\Library;
use Core\Services\ResourceLoader;

class LibraryController extends Library{
    public function addToLibrary(){
        $data = json_decode(file_get_contents('php://input'));
        if($this->add($data->bookId, $_SESSION['USER_ID'])){
            echo "true";
        }else{
            echo "false";
        }
    }

    public function removeFromLibrary(){
        $data = json_decode(file_get_contents('php://input'));
        if($this->remove($data->libraryId)){
            echo "true";
        }else{
            echo "false";
        }
    }

    public function load(){
        $rows = $this->get();
        if($rows !== false){
            foreach($rows as $row){
                $book = new Book;
                $bookRow = $book->getById($row['bookId']);
                $cover = Application::$HOST."/uploads/books/covers/".$bookRow['bookCover'];
                $description = substr($bookRow['bookDescription'], 0, 400);
                $removeBtn = ResourceLoader::loadIcon('delete.svg');
                $bookLink = Application::$HOST."/book/{$bookRow['bookName']}";
                echo "<div class='book-wrapper'>
                            <a href='{$bookLink}' class='left'>
                                <img src='{$cover}'>
                            </a>
                            <div class='right'>
                                <a href='{$bookLink}' class='title'>
                                    {$bookRow['bookName']}
                                </a>
                                <div class='description'>
                                    {$description}
                                </div>
                                <button data-library-id='{$row['libraryId']}' onclick='removeFromLibrary(this)'>{$removeBtn}Remove</button>
                            </div>
                        </a>
                    </div>";
            }
        }else{
            echo 'Nothing found!';
        }
    }
}