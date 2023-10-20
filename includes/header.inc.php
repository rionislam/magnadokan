<?php
@session_start();
$application = new App\Application;
?>
<section class="navigation">
            <div class="navigation-container max-width center">
                <header><a href="<?=App\Application::$HOST?>"><h1>Magna Do<span class="accent-1">kan.</span></h1></a></header>
                <img id="menuBtn" src="imgs/menu.svg" onclick="showMenu(this)" alt="Mobile Menu Button">
                <nav class="landscape">
                    <ul>
                        <li><a href="<?=App\Application::$HOST?>/categories">Popular Catagories</a></li>
                        <li><a href="<?=App\Application::$HOST?>/books/language=English">English Books</a></li>
                        <li><a href="<?=App\Application::$HOST?>/books/language=Bangla">Bangla Books</a></li>
                        <li>
                            <form class="search-bar" action="<?=App\Application::$HOST?>/controllers/search.controller.php" method="post">
                            <input type="text" name="search" placeholder="Search here...">
                            <input type="image" src="imgs/search.svg" alt="Search Button">
                            </form></li>
                        <li><?=($application->checkUserLogin()) ? '<img src="imgs/account_circle.svg">':'<button class="loginBtn" onclick="showLoginSignup()">Login</button>'?></li>
                    </ul>
                </nav>
                <nav class="vertical">
                    <ul>
                        <li><?=($application->checkUserLogin()) ? '<img src="imgs/account_circle.svg">':'<button class="loginBtn" onclick="showLoginSignup()">Login</button>'?></li>
                        <li>
                            <form class="search-bar" action="<?=App\Application::$HOST?>/controllers/search.controller.php" method="post">
                            <input type="text" name="search" placeholder="Search here...">
                            <input type="image" src="imgs/search.svg" alt="Search Button">
                            </form>
                        </li>
                        <li><a href="<?=App\Application::$HOST?>/categories">Popular Catagories</a></li>
                <li><a href="<?=App\Application::$HOST?>/books/language=English">English Books</a></li>
                <li><a href="<?=App\Application::$HOST?>/books/language=Bangla">Bangla Books</a></li>
                    </ul>
                </nav>
            </div>
        </section>
<div style="height: 3.5rem;"></div>