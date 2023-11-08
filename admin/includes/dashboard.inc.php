<?php 
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
new App\Application;
$writter = new App\Writter;
$book = new App\Book;
?>
<link rel="stylesheet" href="css/dashboard.css">
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
                    <?= file_get_contents(App\Application::$HOST."/imgs/books.svg")?>
                </div>
            </div>
            <div class="middle">
                <div class="number">
                    <?= $book->count();?>
                </div>
                <div class="preview-title">
                    Total Books
                </div>
            </div>
            <div class="right" title="Monthly growth">
                <div class="icon">
                    <?= file_get_contents(App\Application::$HOST."/imgs/growth.svg")?>
                </div>
                <div class="number">
                    7%
                </div>
            </div>
        </div>
    </div>
    <div class="preview-container">
        <div class="preview-cart">
            <div class="left">
                <div class="icon">
                    <?= file_get_contents(App\Application::$HOST."/imgs/account_circle.svg")?>
                </div>
            </div>
            <div class="middle">
                <div class="number">
                    <?=$user->count()?>
                </div>
                <div class="preview-title">
                    Total Users
                </div>
            </div>
            <div class="right" title="Monthly growth">
                <div class="icon">
                    <?= file_get_contents(App\Application::$HOST."/imgs/growth.svg")?>
                </div>
                <div class="number">
                    7%
                </div>
            </div>
        </div>
    </div>
    <div class="preview-container">
        <div class="preview-cart">
            <div class="left">
                <div class="icon">
                    <?= file_get_contents(App\Application::$HOST."/imgs/download.svg")?>
                </div>
            </div>
            <div class="middle">
                <div class="number">
                    70020
                </div>
                <div class="preview-title">
                    Total Downloads
                </div>
            </div>
            <div class="right" title="Monthly growth">
                <div class="icon">
                    <?= file_get_contents(App\Application::$HOST."/imgs/growth.svg")?>
                </div>
                <div class="number">
                    7%
                </div>
            </div>
        </div>
    </div>
    <div class="preview-container">
        <div class="preview-cart">
            <div class="left">
                <div class="icon">
                    <?= file_get_contents(App\Application::$HOST."/imgs/dashboard.svg")?>
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
                    <?= file_get_contents(App\Application::$HOST."/imgs/growth.svg")?>
                </div>
                <div class="number">
                    7%
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ANCHOR Analitics Section -->
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
        <?=$book->loadPopular(5)?>
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
<script src="<?=App\Application::$HOST?>/admin/js/create-pie.js"></script>
