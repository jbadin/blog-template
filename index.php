<?php
session_start();
require_once 'router.php';

$router = new Router();

//Account routes
$router->addRoute('/account', 'account', 'account');
$router->addRoute('/activate', 'account', 'activate');
$router->addRoute('/login', 'account', 'login');
$router->addRoute('/logout', 'account', 'logout');
$router->addRoute('/signup', 'account', 'signup');

//Pages routes
$router->addRoute('/', 'pages', 'home');
$router->addRoute('/home', 'pages', 'home');
$router->addRoute('/about', 'pages', 'about');
$router->addRoute('/contact', 'pages', 'contact');

//Blog routes
$router->addRoute('/create-post', 'blog', 'create');
$router->addRoute('/update-post', 'blog', 'update');
$router->addRoute('/update-post-image', 'blog', 'updateImage');
$router->addRoute('/delete-post', 'blog', 'delete');
$router->addRoute('/blog', 'blog', 'list');
$router->addRoute('/read', 'blog', 'read');

$router->dispatch();