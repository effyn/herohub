<?php
//Name: Alicia Buehner, Evan Wheeler
//Date: TODO: fill in due date
//Description: This file contains the index page for...

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require vendor/autoload file
require_once('vendor/autoload.php');
//TODO: Require validation function files here

//Create an instance of the Base class (instantiate Fat-Free)
$f3 = Base::instance();

// Start session
session_start();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//TODO: define additional routes below...

//Define a default route
$f3->route('GET /', function() {
    $view = new Template();
    echo $view->render('views/homepage.html');
});

$f3->route('GET /register', function() {
    $view = new Template();
    echo $view->render('views/account.html');
});

$f3->route('GET /preferences', function() {
    $view = new Template();
    echo $view->render('views/preferences.html');
});

$f3->route('GET /heroes', function() {
    $view = new Template();
    echo $view->render('views/heroes.html');
});

//Run Fat-free
$f3->run();