<?php
use Core\Services\ResourceLoader;
echo ResourceLoader::loadComponentCss('admin-nav');
?>
<nav>
    <header>
        <h1>Admin Panel</h1>
    </header>
    <hr>
    <ul>
        <li onclick="navigate(this)" data-page="dashboard" class="<?=(pageName=="admin-dashboard")?'active':'';?>"><a href="/admin/dashboard"><?=ResourceLoader::loadIcon('dashboard.svg')?>Dashboard</a></li>
        <li onclick="navigate(this)" data-page="users" class="<?=(pageName=="admin-users")?'active':'';?>"><a href="/admin/users/1"><?=ResourceLoader::loadIcon('users.svg')?>Users</a></li>
        <li onclick="navigate(this)" data-page="books" class="<?=(pageName=="admin-books")?'active':'';?>"><a href="/admin/books/1"><?=ResourceLoader::loadIcon('books.svg')?>Books</a></li>
        <li onclick="navigate(this)" data-page="categories" class="<?=(pageName=="admin-categories")?'active':'';?>"><a href="/admin/categories"><?=ResourceLoader::loadIcon('categories.svg')?>Categories</a></li>
        <li onclick="navigate(this)" data-page="writters" class="<?=(pageName=="admin-writters")?'active':'';?>"><a href="/admin/writters"><?=ResourceLoader::loadIcon('writters.svg')?>Writters</a></li>
        <li onclick="navigate(this)" data-page="languages" class="<?=(pageName=="admin-languages")?'active':'';?>"><a href="/admin/languages"><?=ResourceLoader::loadIcon('languages.svg')?>Languages</a></li>
        <li onclick="navigate(this)" data-page="settings" class="<?=(pageName=="admin-settings")?'active':'';?>"><a href="/admin/settings"><?=ResourceLoader::loadIcon('settings.svg')?>Settings</a></li>
    </ul>
</nav>
<?=ResourceLoader::loadComponentJs('admin-nav')?>