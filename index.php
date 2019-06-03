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

//Define a default route to homepage
$f3->route('GET /', function() {
    $view = new Template();
    echo $view->render('views/homepage.html');
});

//Define route for the first form page user registration information
$f3->route('GET|POST /register', function() {
    $view = new Template();
    echo $view->render('views/register.html');
});

//Define route for second form page user play style settings
$f3->route('GET|POST /preferences', function() {
    $view = new Template();
    echo $view->render('views/preferences.html');
});

//Define route for the third form page user player preferences
$f3->route('GET|POST /heroes', function() {
    $view = new Template();
    echo $view->render('views/heroes.html');
});

//Define route for the registration summary page
$f3->route('GET|POST /summary', function() {
    $view = new Template();
    echo $view->render('views/summary.html');
});

//Define route for the user login page
$f3->route('GET|POST /login', function() {
    $view = new Template();
    echo $view->render('views/login.html');
});

//Define route for the user dashboard page
$f3->route('GET|POST /dashboard', function() {
    $view = new Template();
    echo $view->render('views/dashboard.html');
});

//Run Fat-free
$f3->run();