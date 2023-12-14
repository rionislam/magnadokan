<?php
@session_start();
require __DIR__.'/vendor/autoload.php';

use Core\Application;
use Core\Services\ClientService;
use Core\Services\ErrorHandler;
use Core\Services\SessionService;

// Check the session
$sessionService = new SessionService;
$sessionService->init();

// Check the client
$clientService = new ClientService;
$clientService->init();

$application = new Application;

$errorHandaler = new ErrorHandler;

// Instantiate the router
use Core\Services\Router;

// Instantiate the router

new Router();

//ROUTES for USERS

// Routes for the main pages
Router::get('/', 'PageController@loadHome');
Router::get('/login', 'PageController@loadLogin');
Router::get('/signup', 'PageController@loadSignup');
Router::get('/book-request', 'PageController@loadBookRequest');
Router::get('/fairuse', 'PageController@loadFairuse');
Router::get('/dmca', 'PageController@loadDmca');
Router::get('/disclaimer', 'PageController@loadDisclaimer');
Router::get('/privacy-policy', 'PageController@loadPrivacyPolicy');
Router::get('/fairuse', 'PageController@loadFairuse');
Router::get('/about', 'PageController@loadAbout');
Router::get('/library', 'PageController@loadLibrary');

// Routes for the books
Router::get('/book/{name}/download', 'PageController@downloadBook');
Router::get('/book/{name}', 'PageController@loadBook');
Router::get('/books/category/{category}/{page}', 'PageController@loadBooksByCategory');
Router::get('/books/language/{language}/{page}', 'PageController@loadBooksByLanguage');
Router::get('/books/{page}', 'PageController@loadAllBooks');
Router::get('/search/{keyword}/{page}', 'PageController@loadBooksByKeyword');
Router::post('/search', 'SearchController@search');
Router::post('/process-login', 'UserController@processLogin');
Router::post('/process-signup', 'UserController@processSignup');
Router::post('/process-book-request', 'BookController@processBookRequest');
Router::get('/logout', 'UserController@logout');
Router::put('/add-to-library', 'LibraryController@addToLibrary');
Router::put('/collect-book-log', 'LogController@collectBookLog');
Router::del('/remove-from-library', 'LibraryController@removeFromLibrary');


//ROUTES FOR ADMIN
Router::get('/admin', 'AdminPageController@loadDashboard');
Router::get('/admin/', 'AdminPageController@loadDashboard');
Router::get('/admin/login', 'AdminPageController@loadLogin');
Router::post('/admin/process-login', 'AdminController@processLogin');
Router::get('/admin/dashboard', 'AdminPageController@loadDashboard');
Router::get('/admin/users', 'AdminPageController@loadUsers');
Router::get('/admin/books', 'AdminPageController@loadBooks');
Router::get('/admin/add-book', 'AdminPageController@loadAddBook');
Router::post('/admin/process-add-book', 'AdminBookController@addBook');
Router::get('/admin/book-details/{id}', 'AdminPageController@loadBookDetails');
Router::post('/admin/process-update-book', 'AdminBookController@updateBook');

Router::get('/admin/categories', 'AdminPageController@loadCategories');
Router::get('/admin/add-category', 'AdminPageController@loadAddCategory');
Router::post('/admin/process-add-category', 'AdminCategoryController@addCategory');

Router::get('/admin/writters', 'AdminPageController@loadWritters');
Router::get('/admin/add-writter', 'AdminPageController@loadAddWritter');
Router::post('/admin/process-add-writter', 'AdminWritterController@addWritter');

Router::get('/admin/settings', 'AdminPageController@loadSettings');
Router::post('/admin/save-settings', 'AdminSettingsController@saveSettings');

Router::post('/admin/upload-image', 'AdminFileController@uploadImage');


// Dispatch the request
Router::dispatch();