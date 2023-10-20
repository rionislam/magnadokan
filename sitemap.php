<?php
header('Content-type: App\Application/xml');
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
new App\Application;
$book = new App\Book;
$booksCount = $book->count('');
$category = new App\Category;
$categoriesCount = $category->count('');
$count = $booksCount + $categoriesCount;
$limit = $_GET['limit'];
$output = '<urlset
                xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$date = date('c');
$output .= "<url>
            <loc>".App\Application::$HOST."</loc>
            <lastmod>{$date}</lastmod>
            <priority>1.00</priority>
            </url>";
$output .= "<url>
            <loc>".App\Application::$HOST."/about</loc>
            <lastmod>{$date}</lastmod>
            <priority>0.8</priority>
            </url>";
$output .= "<url>
            <loc>".App\Application::$HOST."/dmca</loc>
            <lastmod>{$date}</lastmod>
            <priority>0.6</priority>
            </url>";
$output .= "<url>
            <loc>".App\Application::$HOST."/disclaimer</loc>
            <lastmod>{$date}</lastmod>
            <priority>0.6</priority>
            </url>";
$output .= "<url>
            <loc>".App\Application::$HOST."/fairuse</loc>
            <lastmod>{$date}</lastmod>
            <priority>0.6</priority>
            </url>";

    $bookRows = $book->getLimited("0,{$booksCount}", '');
    foreach($bookRows as $row){
        $bookName = str_replace(' ', '%20', $row['bookName']);
        $output .= "<url>
            <loc>".App\Application::$HOST."/book/{$bookName}</loc>
            <lastmod>{$date}</lastmod>
            <priority>0.8</priority>
            </url>";
    }

    $categoryRows = $category->getLimited("0,{$categoriesCount}", '');
    foreach($categoryRows as $row){
        $categoryName = str_replace(' ', '%20', $row['category']);
        $output .= "<url>
            <loc>".App\Application::$HOST."/books/category={$categoryName}</loc>
            <lastmod>{$date}</lastmod>
            <priority>0.8</priority>
            </url>";
    }

$output .= "</urlset>";
echo $output;
exit();