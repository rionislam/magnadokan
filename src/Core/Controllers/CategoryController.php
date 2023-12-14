<?php
namespace Core\Controllers;

use Core\Application;
use Core\Models\Category;

class CategoryController extends Category{

    public function categoriesAdded(){
        return $this->count();
    }

    public function loadUrlsForSitemap(){
        $date = date('Y-m-d\TH:i:sP');
        $categoriesCount = $this->count();
        $categoryRows = $this->getLimited("0,{$categoriesCount}", '');
        $output = '';
        foreach($categoryRows as $row){
            $categoryName = str_replace(' ', '%20', $row['category']);
            $output .= "<url>
                <loc>".Application::$HOST."/books/category={$categoryName}</loc>
                <lastmod>{$date}</lastmod>
                <priority>0.8</priority>
                </url>";
        }
        return $output;
    }

    public function loadPopularList(){
        $rows = $this->getLimited('0,9', 'ORDER BY `clicks` DESC,`downloads` DESC');
        if($rows !== false){
            foreach($rows as $row){
                echo "<article>
                        <a href='books/category/{$row['category']}/1'>
                            <img class='logo' src='uploads/categories/icons/{$row['categoryIcon']}' alt='{$row['category']} Books'><p class='name'>{$row['category']}</p>
                        </a>
                    </article>";
            }
        }else{
            echo 'Nothing found!';
        }
    }
}