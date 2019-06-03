<?php
//Name: Alicia Buehner, Evan Wheeler
//Date: TODO: fill in due dates - Project due June 10th @ 10:00am
//Description: This file contains the index page for...

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require vendor/autoload file
require_once('vendor/autoload.php');
require_once('model/validation-functions.php');

// Start session
session_start();

//Create an instance of the Base class (instantiate Fat-Free)
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define a default route to homepage
$f3->route('GET /', function() {
    $view = new Template();
    echo $view->render('views/homepage.html');
});

//Define route to the first form page user registration information
$f3->route('GET|POST /register', function($f3) {

    //get data from form - $variable = $_POST['']

    $fName = $_POST['first'];
    $lName = $_POST['last'];
    $battleTag =  $_POST['battletag'];
    $email =  $_POST['email'];
    $pw =  $_POST['password'];
    $pw2 =  $_POST['password2'];

    //add data to the hive - $f3->set('', $variable)

    $f3->set('fname', $fName);
    $f3->set('lname',  $lName);
    $f3->set('battletag', $battleTag);
    $f3->set('email', $email);
    $f3->set('password', $pw);
    $f3->set('password2', $pw2);


    //if valid add to session (valid form) set session to variable
        //redirect to preferences page

    if (validForm1()) {
        //TODO set the session variables

        //Redirect to preferences
        $f3->reroute('/preferences');
    }

    $view = new Template();
    echo $view->render('views/register.html');
});

//Define route to second form page user play style settings
$f3->route('GET|POST /preferences', function() {

    //get data from form - $variable = $_POST['']

    //add data to the hive - $f3->set('', $variable)

    //if valid add to session (valid form) set session to variable
        //redirect to heroes page

    $view = new Template();
    echo $view->render('views/preferences.html');
});

//Define route to the third form page user player preferences
$f3->route('GET|POST /heroes', function() {

    //get data from form -  $variable = $_POST['']

    //add data to the hive - $f3->set('', $variable)

    //if valid add to session (valid form) set session to variable
        //redirect to summary page
    $view = new Template();
    echo $view->render('views/heroes.html');
});

//Define route to the registration summary page
$f3->route('GET|POST /summary', function() {
    $view = new Template();
    echo $view->render('views/summary.html');
});

//Define route to the user login page
$f3->route('GET|POST /login', function() {

    //get data from form -  $variable = $_POST['']

    //add data to the hive - $f3->set('', $variable)

    //if valid add to session (valid login form) set session to variable
    //redirect to dashboard page

    $view = new Template();
    echo $view->render('views/login.html');
});

//Define route to the user dashboard page
$f3->route('GET|POST /dashboard', function() {
    $view = new Template();
    echo $view->render('views/dashboard.html');
});

//Run Fat-free
$f3->run();