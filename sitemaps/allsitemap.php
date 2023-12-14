<?php

use Core\Application;
use Core\Controllers\BookController;
use Core\Controllers\CategoryController;

header('Content-type: App\Application/xml');
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
new Application;
$bookController = new BookController;
$booksCount = $bookController->booksAdded();
$categoryController = new CategoryController;
$categoriesCount = $categoryController->categoriesAdded();
$count = $booksCount + $categoriesCount;
$output = '<?xml version="1.0" encoding="UTF-8"?>';
$output .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
for($i=0; $i<$count; $i +=25000){
    $output .= "<sitemap>";
    $output .=    "<loc>".Application::$HOST."/sitemaps/sitemap.php?limit=".$i."</loc>"; 
    $output .= "</sitemap>";
}
$output .= "</sitemapindex>";
echo $output;
exit();
