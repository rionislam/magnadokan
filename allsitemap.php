<?php
header('Content-type: App\Application/xml');
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
new App\Application;
$book = new App\Book;
$booksCount = $book->count('');
$category = new App\Category;
$categoriesCount = $category->count('');
$count = $booksCount + $categoriesCount;
$output = '<?xml version="1.0" encoding="UTF-8"?>';
$output .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
for($i=0; $i<$count; $i +=25000){
    $output .= "<sitemap>";
    $output .=    "<loc>".App\Application::$HOST."/sitemap.php?limit=".$i."</loc>"; 
    $output .= "</sitemap>";
}
$output .= "</sitemapindex>";
echo $output;
exit();
