<?php
namespace App;

class Category extends Dbh{
    public function get($category){
        $sql = 'SELECT * FROM `categories` WHERE `category`="'.$category.'";';
        $row = $this->getRows($sql)[0];
        return $row;
    }

    public function count($condition){
        $sql= "SELECT * FROM `categories` {$condition};";
        $result = $this->getResult($sql);
        return $result->num_rows;
    }

    public function load(){
        $rows = $this->selectAll('categories');
        if($rows !== false){
            $detailsLogo = file_get_contents(Application::$ROOT_DIR."/imgs/details.svg");
            foreach($rows as $row){
                echo "<div class='row'><div class='icon'><img src='".Application::$HOST."/uploads/".$row['categoryIcon']."'></div><div class='name'>".$row['category']."</div><div class='details'>$detailsLogo</div></div>";
            }
        }else{
            echo 'Nothing found!';
        }
        
    }

    public function loadList(){
        $rows = $this->selectAll('categories');
        if($rows !== false){
            foreach($rows as $row){
                echo "<li onclick='selectCategory(this)'>".$row['category']."</li>";
            }
        }else{
            echo 'Nothing found!';
        }
    }

    public function add($name, $file){
        $allowed = array('jpg', 'jpeg', 'png');
        $fileClass = new File;
        $fileName = explode('.',$file['name'])[0];
        $fileName = $fileClass->upload($file, $allowed, 50);

        if($fileName != false){
            $response = $this->createRow('categories', ['`category`', '`categoryIcon`'], 'ss', $name, $fileName);
            if($response !== false){
                return true;
            } 
        }

    }

    public function getLimited($limit, $condition){
        $sql = "SELECT * FROM `categories` {$condition} Limit {$limit};";
        $row = $this->getRows($sql);
        return $row;
    }


    public function loadPopularList(){
        $rows = $this->getLimited('0,20', 'ORDER BY `clicks` DESC,`downloads` DESC');
        if($rows !== false){
            foreach($rows as $row){
                echo "<article>
                        <a href='books/category={$row['category']}'>
                            <img class='logo' src='uploads/{$row['categoryIcon']}' alt='{$row['category']} Books'><p class='name'>{$row['category']}</p>
                        </a>
                    </article>";
            }
        }else{
            echo 'Nothing found!';
        }
    }

    public function click($category){
        $clicks = $this->get($category)['clicks']+1;
        $this->updateData('categories', ['clicks'], 'i', " WHERE `category`='{$category}'", $clicks);
    }

    public function download($category){
        $downloads = $this->get($category)['downloads']+1;
        $this->updateData('categories', ['downloads'], 'i', " WHERE `category`='{$category}'", $downloads);
    }
}