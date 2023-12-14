<?php
use Core\Application;
use Core\Services\ResourceLoader;
use Core\Services\SessionService;

?>
<?=ResourceLoader::loadComponentCss('header')?>
<section class="navigation">
            <div class="navigation-container max-width center">
                <header><a href="<?=Application::$HOST?>"><h1>Magna Do<span class="accent-1">kan.</span></h1></a></header>
                <img id="menuBtn" src="assets/images/icons/menu.svg" onclick="showMenu(this)" alt="Mobile Menu Button">
                <nav class="landscape">
                    <ul>
                        <li class="search_bar-container">
                            <form class="search_bar" action="<?=Application::$HOST?>/search" method="post">
                            <input type="text" name="search" placeholder="Search here...">
                            <input type="image" src="/assets/images/icons/search.svg" alt="Search Button">
                            </form>
                        </li>
                        <?php
                        if(!SessionService::isLoggedIn()){
                            ?>
                            <button class="login-btn" onclick="showLoginSignup()">Login</button>
                            <?php
                        }else{
                            ?>
                            <div class="account_menu">
                                <li class="account_menu-btn"><img src="assets/images/icons/account_circle.svg"><?=$_SESSION['USER_NAME']?></li>
                                <div class="account_menu-container">
                                    <div class="account_menu-wrapper">
                                        <li><a href="<?=Application::$HOST?>\library"><?php include Application::$HOST."/assets/images/icons/manage_accounts.svg"?>Manage My Account</a></li>
                                        <li><a href="<?=Application::$HOST?>\library"><?php include Application::$HOST."/assets/images/icons/library.svg"?>My Library</a></li>
                                        <li><a href="<?=Application::$HOST?>\logout"><?php include Application::$HOST."/assets/images/icons/logout.svg"?>Logout</a></li>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        
                        <?=(SessionService::isLoggedIn()) ? '':'<li><button class="downloads-left-btn" onclick="showDownloadsLeft()">+0</button></li>'?>

                    </ul>
                </nav>
                <nav class="vertical">
                    <ul>
                        <?php
                        if(SessionService::isLoggedIn()){
                            ?>
                            <li><img src="assets/images/icons/account_circle.svg"> <span><?=$_SESSION['USER_NAME']?></span></li>
                            <?php
                        }else{
                            ?>
                            <li class="buttons"><button class="login-btn" onclick="showLoginSignup()">Login</button><button class="downloads-left-btn" onclick="showDownloadsLeft()">+0</button></li>
                            <?php
                        }
                        ?>
                       
                        <li class="search_bar-container">
                            <form class="search_bar" action="<?=Application::$HOST?>/search" method="post">
                            <input type="text" name="search" placeholder="Search here..." alt="Search Input">
                            <input type="image" src="assets/images/icons/search.svg" alt="Search Button">
                            </form>
                        </li>
                        <?php
                            if(SessionService::isLoggedIn()){
                        ?>
                                <li>
                                    <a href="<?=Application::$HOST?>\library"><img src="assets/images/icons/manage_accounts.svg">My Account</a>
                                </li>
                                <li>
                                    <a href="<?=Application::$HOST?>\library"><img src="assets/images/icons/library.svg">Library</a>
                                </li>
                                <li>
                                    <a class="logoutBtn" href="<?=Application::$HOST?>\logout"><img src="assets/images/icons/logout.svg">Logout</a>
                                </li>
                        <?php
                            }else{
                        ?>
                                <li><a href="<?=Application::$HOST?>/categories">Popular Catagories</a></li>
                                <li><a href="<?=Application::$HOST?>/books/language/English/1">English Books</a></li>
                                <li><a href="<?=Application::$HOST?>/books/language/Bangla/1">Bangla Books</a></li>
                        <?php
                            }
                        ?>
                    </ul>
                </nav>
            </div>
</section>
<?=ResourceLoader::loadComponentJs('header')?>
<div style="height: 3.6rem;"></div>