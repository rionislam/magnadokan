<?php
// define the pagename for selecting the active nav bar
define('pageName', 'admin-dashboard');

use Core\Services\HtmlGenerator;
use Core\Services\ResourceLoader;
use Core\Controllers\AdminBookController;
use Core\Controllers\AdminLogController;
use Core\Controllers\AdminUserController;
use Core\Services\AdminAuthHandler;
use Core\Services\ErrorHandler;

if(!AdminAuthHandler::isLoggedIn()){
    ErrorHandler::displayErrorPage(403);
    exit;
}
$adminBookController = new AdminBookController;
$adminUserController = new AdminUserController;
$adminLogController = new AdminLogController;
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?=HtmlGenerator::generateAdminHead('Dashboard', pageName)?>
</head>
<body>

<?=ResourceLoader::loadComponent('admin-nav')?>
<main>
<header>
    <div class="left">
        <div class="title">Dashboard</div>
    </div>
    <div class="right">
    </div>
</header>
<hr>
<!-- ANCHOR Short Preview section -->
<section class="short-preview preview">
    <div class="preview-container">
        <div class="preview-cart">
            <div class="left">
                <div class="icon">
                    <?=ResourceLoader::loadIcon('books.svg')?>
                </div>
            </div>
            <div class="middle">
                <div class="number">
                <?=$adminBookController->count()?>
                </div>
                <div class="preview-title">
                    Total Books
                </div>
            </div>
            <div class="right" title="Monthly growth">
                <div class="icon">
                    <?php
                    $booksIncreased = $adminBookController->booksIncreased();
                    if($booksIncreased > 0){
                        echo ResourceLoader::loadIcon('increase.svg');
                    }else{
                        echo ResourceLoader::loadIcon('decrease.svg');
                    }
                    ?>
                </div>
                <div class="number">
                    <?=$booksIncreased?>%
                </div>
            </div>
        </div>
    </div>
    <div class="preview-container">
        <div class="preview-cart">
            <div class="left">
                <div class="icon">
                    <?=ResourceLoader::loadIcon('account_circle.svg')?>
                </div>
            </div>
            <div class="middle">
                <div class="number">
                    <?=$adminUserController->count()?>
                </div>
                <div class="preview-title">
                    Total Users
                </div>
            </div>
            <div class="right" title="Monthly growth">
                <div class="icon">
                <?php
                    $usersIncreased = $adminUserController->usersIncreased();
                    if($usersIncreased > 0){
                        echo ResourceLoader::loadIcon('increase.svg');
                    }else{
                        echo ResourceLoader::loadIcon('decrease.svg');
                    }
                    ?>
                </div>
                <div class="number">
                    <?=$usersIncreased?>%
                </div>
            </div>
        </div>
    </div>
    <div class="preview-container">
        <div class="preview-cart">
            <div class="left">
                <div class="icon">
                    <?= ResourceLoader::loadIcon('download.svg')?>
                </div>
            </div>
            <div class="middle">
                <div class="number">
                    <?=$adminLogController->downloadsCount();?>
                </div>
                <div class="preview-title">
                    Total Downloads
                </div>
            </div>
            <div class="right" title="Monthly growth">
                <div class="icon">
                <?php
                    $downloadsIncreased = $adminLogController->downloadsIncreased();
                    if($downloadsIncreased > 0){
                        echo ResourceLoader::loadIcon('increase.svg');
                    }else{
                        echo ResourceLoader::loadIcon('decrease.svg');
                    }
                    ?>
                </div>
                <div class="number">
                    <?=$downloadsIncreased?>%
                </div>
            </div>
        </div>
    </div>
    <div class="preview-container">
        <div class="preview-cart">
            <div class="left">
                <div class="icon">
                    <?= ResourceLoader::loadIcon('dashboard.svg')?>
                </div>
            </div>
            <div class="middle">
                <div class="number">
                    70020
                </div>
                <div class="preview-title">
                    Book Requests
                </div>
            </div>
            <div class="right" title="Monthly growth">
                <div class="icon">
                    <?=ResourceLoader::loadIcon('growth.svg')?>
                </div>
                <div class="number">
                    7%
                </div>
            </div>
        </div>
    </div>
</section>
<!-- SECTION Analitics Section -->
<section class="analytics">
 <div class="left">
    <div class="title-wrapper">
        <div class="title">Top peforming books</div>
    </div>
    <div class="top_books-wrapper">
        <div class="top_book header">
            <div class="top_book-cover">Cover</div>
            <div class="top_book-name">Name</div>
            <div class="top_book-impressions">Clicks</div>
            <div class="top_book-downloads">Downloads</div>
        </div>
        <?=$adminBookController->loadPopularBooks();?>
    </div>
 </div>
 <div class="right">
    <div class="title-wrapper">
        <div class="title">Top peforming catagories</div>
    </div>
    <div class="chart-wrapper">
        <div class="pie_chart">
            <canvas id="pie_chart"></canvas>
        </div>
        <div class="chart_info">
            <div class="chart_info-wrapper">
                <div class="palet" style="background: var(--accent-1);"></div>
                <div class="catagory-name">Programming</div>
            </div>
            <div class="chart_info-wrapper">
                <div class="palet" style="background: var(--green);"></div>
                <div class="catagory-name">Fiction</div>
            </div>
            <div class="chart_info-wrapper">
                <div class="palet" style="background: var(--danger);"></div>
                <div class="catagory-name">Non fiction</div>
            </div>
            <div class="chart_info-wrapper">
                <div class="palet" style="background: var(--dark-color);"></div>
                <div class="catagory-name">Others</div>
            </div>
        </div>
    </div>
 </div>
</section>
</main>
<?=ResourceLoader::loadPageJs(pageName)?>
</body>
</html>