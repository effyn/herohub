<?php
//Name: Alicia Buehner, Evan Wheeler
//Date: TODO: fill in due dates - Project due June 10th @ 10:00am
//Description: This file contains the index page for the HeroHub IT328 Final Project
//TODO: MAKE SURE ALL FILES HAVE A HEADER COMMENTS, also IMGs of Database or file push to git??

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require vendor/autoload file
require_once('vendor/autoload.php');

// Start session
session_start();

// TODO: remove this line
//var_dump($_SESSION);

//Create an instance of the Base class (instantiate Fat-Free)
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//TODO: Create Database object here

//expected values for form fields
$f3->set('platforms', array( 'pc' => 'PC', 'psn' => 'PS4', 'xbl' => "Xbox One"));
$f3->set('memberships', 'Sign up for Premium Access and gain preferred character matching!');
$f3->set('regions', array('America', 'Europe', 'Asia'));
//TODO define character drop down expect values

//Define a default route to homepage
$f3->route('GET /', function() {
    $view = new Template();
    echo $view->render('views/homepage.html');
});

//Define route to the first form page user registration information
$f3->route('GET|POST /register', function($f3) {

    //if post is not empty
    if (!empty($_POST)) {
        //get data from form - $variable = $_POST['']
        $platform = $_POST['platform'];
        $email =  $_POST['email'];
        $pw =  $_POST['password'];
        $pw2 =  $_POST['password2'];
        $membership = $_POST['membership'];

        //add data to the hive - $f3->set('', $variable)
        $f3->set('platform', $platform);
        $f3->set('email', $email);
        $f3->set('password', $pw);
        $f3->set('password2', $pw2);
        $f3->set('membership', $membership);

        //if valid add to session (valid form) set session to variable
            //redirect to preferences page
        if (validForm1()) {
            //hash password after valid check
            //FIXME this is string(60) but it can change depending on the PHP version
            //  so store in the database as VARCHAR(255)
            $pw = password_hash($_POST['password'], PASSWORD_DEFAULT);

            if (!empty($membership)) {
                $newUser = new PremiumUser($platform, $email, $pw);
            } else {
                $newUser = new User($platform, $email, $pw);
            }
            $_SESSION['user'] = $newUser;

            //Redirect to preferences
            $f3->reroute('/preferences');
        }
    }

    $view = new Template();
    echo $view->render('views/register.html');
});

//Define route to second form page user play style settings
$f3->route('GET|POST /preferences', function($f3) {

    // if post is not empty
    if (!empty($_POST)) {

        //get data from form - $variable = $_POST['']
        $tag = $_POST['tag'];
        $mic = $_POST['mic'];
        $leadership = $_POST['leader'];

        //if user is a pc player gather region field
        if ($_SESSION['user']->getPlatform() == 'pc') {  //FIXME this was what was causing the error
            $region = $_POST['region'];
            //set to hive here
            $f3->set('region', $region);
        }

        //add data to the hive - $f3->set('', $variable)
        $f3->set('tag', $tag);
        $f3->set('mic', $mic);
        $f3->set('leadership', $leadership);

        //if valid add to session (valid form) set session to variable
        //redirect to heroes page if PremiumUser
        if (validForm2())
        {
            //TODO: call setters for session user and reroute,
            // reroute to summary otherwise if premium reroute to heroes

            //Redirect to heroes
            $f3->reroute('/heroes');
        }
    }

    $view = new Template();
    echo $view->render('views/preferences.html');
});

//Define route to the third form page user player preferences
$f3->route('GET|POST /heroes', function() {
    //TODO: only premium access members see this route

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