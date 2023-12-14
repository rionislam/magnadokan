<?php

use Core\Application;
use Core\Controllers\BookController;
use Core\Controllers\CategoryController;

header('Content-type: App\Application/xml');
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
new Application;
$bookController = new BookController;
$categoryController = new CategoryController;
$limit = $_GET['limit'];
$output = '<urlset
                xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$date = date('Y-m-d\TH:i:sP');
$output .= "<url>
            <loc>".Application::$HOST."</loc>
            <lastmod>{$date}</lastmod>
            <priority>1.00</priority>
            </url>";
$output .= "<url>
            <loc>".Application::$HOST."/privacy-policy</loc>
            <lastmod>2023-11-10T17:36:38+00:00</lastmod>
            <priority>1</priority>
            </url>";
$output .= "<url>
            <loc>".Application::$HOST."/about</loc>
            <lastmod>2023-11-10T17:36:38+00:00</lastmod>
            <priority>0.8</priority>
            </url>";
$output .= "<url>
            <loc>".Application::$HOST."/dmca</loc>
            <lastmod>2023-11-10T17:36:38+00:00</lastmod>
            <priority>0.6</priority>
            </url>";
$output .= "<url>
            <loc>".Application::$HOST."/disclaimer</loc>
            <lastmod>2023-11-10T17:36:38+00:00</lastmod>
            <priority>0.6</priority>
            </url>";
$output .= "<url>
            <loc>".Application::$HOST."/fairuse</loc>
            <lastmod>2023-11-10T17:36:38+00:00</lastmod>
            <priority>0.6</priority>
            </url>";

$output .= $bookController->loadUrlsForSitemap();
$output .= $categoryController->loadUrlsForSitemap();

    

$output .= "</urlset>";
echo $output;
exit();