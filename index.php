<?php
//Name: Alicia Buehner, Evan Wheeler
//Date: 6/10/19
//Description: This file contains the index page for the HeroHub IT328 Final Project

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require vendor/autoload file
require_once('vendor/autoload.php');

// Start session
session_start();

//Create an instance of the Base class (instantiate Fat-Free)
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

// create the database connection, FIXME note: hive variable so that we could get data from views
$f3->set('db', new Database());

//expected values for form fields
$f3->set('platforms', array('pc' => 'PC', 'psn' => 'PS4', 'xbl' => "Xbox One"));
$f3->set('memberships', 'Sign up for Premium Access and gain preferred character matching!');
$f3->set('regions', array('America', 'Europe', 'Asia'));
$f3->set('heroes', array('ana' => 'Ana', 'ashe' => 'Ashe', 'baptiste' => 'Baptiste', 'bastion' => 'Bastion',
    'brigitte' => 'Brigitte', 'dVa' => 'D.Va', 'doomfist' => 'Doomfist', 'genji' => 'Genji', 'hanzo' => 'Hanzo',
    'junkrat' => 'Junkrat', 'lucio' => 'Lúcio', 'mccree' => 'McCree', 'mei' => 'Mei', 'mercy' => 'Mercy',
    'moira' => 'Moira', 'orisa' => 'Orisa', 'pharah' => 'Pharah', 'reaper' => 'Reaper', 'reinhardt' => 'Reinhardt',
    'roadhog' => 'Roadhog', 'soldier76' => 'Soldier: 76', 'sombra' => 'Sombra', 'symmetra' => 'Symmetra',
    'torbjorn' => 'Torbjörn', 'tracer' => 'Tracer', 'widowmaker' => 'Widowmaker', 'winston' => 'Winston',
    'wreckingBall' => 'Wrecking Ball', 'zarya' => 'Zarya', 'zenyatta' => 'Zenyatta'));

//Define a default route to homepage
$f3->route('GET /', function()
{
    $view = new Template();
    echo $view->render('views/homepage.html');
});

//Define route to the first form page user registration information
$f3->route('GET|POST /account', function($f3)
{
    //variable that indicates whether a user is complete
    $loggedIn = isset($_SESSION['user']) && $_SESSION['user']->getId() != 0;

    if (empty($_POST)) {
        if ($loggedIn) {
            $user = $_SESSION['user'];

            $f3->set('platform', $user->getPlatform());
            $f3->set('email', $user->getEmail());
            $f3->set('membership', $user instanceof PremiumUser ? $f3->get('memberships') : '');
        }
    }

    //if post is not empty
    else {
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
            $pw = password_hash($_POST['password'], PASSWORD_DEFAULT);

            if ($loggedIn) {
                if ($platform != $_SESSION['user']->getPlatform()) {
                    // we need to update the tag if the platform changed
                    $_SESSION['platform'] = $platform;
                    $_SESSION['email'] = $email;
                    $_SESSION['passhash'] = $pw;

                   $f3->reroute('/preferences');
                }

                // call the update function
                $f3->get('db')->updateAccount($_SESSION['user']->getId(), $platform, $email, $pw);

                // and redirect them back to the dashboard
                $f3->reroute('/dashboard');
            } else {
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
    }

    $view = new Template();
    echo $view->render('views/account.html');
});

//Define route to second form page user play style settings
$f3->route('GET|POST /preferences', function($f3)
{
    //variable that indicates whether a user is complete
    $loggedIn = isset($_SESSION['user']) && $_SESSION['user']->getId() != 0;

    if (empty($_POST)) {
        if ($loggedIn) {
            $user = $_SESSION['user'];

            $f3->set('tag', $user->getTag());
            $f3->set('mic', $user->getMicPref());
            $f3->set('leadership', $user->getLeaderPref());
            $f3->set('region', $user->getRegion());
        }
    // if post data was supplied
    } else {
        // get data from form - $variable = $_POST['']
        $tag = $_POST['tag'];
        $mic = $_POST['mic'];
        $leadership = $_POST['leader'];
        $region = null;

        //if user is a pc player or is switching to pc
        if ($_SESSION['user']->getPlatform() == 'pc' && !(isset($_SESSION['platform']) ||
            $_SESSION['platform'] == 'pc')) {
            //gather region field
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
        if (validForm2()) {
            $user = $_SESSION['user'];

            $user->setTag($tag);
            $user->setRegion($region);
            $user->setMicPref($mic);
            $user->setLeaderPref($leadership);

            if ($loggedIn) {
                if (isset($_SESSION['platform'])) {
                    // call the update function
                    $f3->get('db')->updateAccount(
                        $_SESSION['user']->getId(), $_SESSION['platform'],
                        $_SESSION['email'], $_SESSION['passhash']);

                    $user->setPlatform($_SESSION['platform']);
                    $user->setEmail($_SESSION['email']);
                    $user->setPasshash($_SESSION['passhash']);

                    unset($_SESSION['platform']);
                    unset($_SESSION['email']);
                    unset($_SESSION['passhash']);
                }

                // call the update function
                $f3->get('db')->updatePreferences($_SESSION['user']->getId(), $tag, $region, $mic, $leadership);

                // and redirect them back to the dashboard
                $f3->reroute('/dashboard');
            }

            //redirect user based on User type
            if ($_SESSION['user'] instanceof PremiumUser) {
                //Redirect to heroes form
                $f3->reroute('/heroes');
            } else {
                //insert the user in the db
                $f3->get('db')->insertUser($user);

                //Redirect to summary
                $f3->reroute('/summary');
            }
        }
    }

    $view = new Template();
    echo $view->render('views/preferences.html');
});

//Define route to the third form page user hero preferences
$f3->route('GET /heroes', function($f3)
{
    if ($_SESSION['user'] instanceof PremiumUser) {
        $view = new Template();
        echo $view->render('views/heroes.html');
    } else {
        //Redirect to summary if not a PremiumUser
        //FIXME this might confuse me later so im making a note here
        $f3->reroute('/summary');
    }
});

//Define route to the third form page user hero preferences
$f3->route('POST /heroes', function($f3)
{
    if (!($_SESSION['user'] instanceof PremiumUser)) {
        //Redirect to summary if not a PremiumUser
        //FIXME this might confuse me later so im making a note here
        $f3->reroute('/summary');
    }

    if (!empty($_POST)) {
        //get data from form -  $variable = $_POST['']
        $role = $_POST['role'];
        $hero1 = $_POST['preferredchar1'];
        $hero2 = $_POST['preferredchar2'];
        $hero3 = $_POST['preferredchar3'];

        //add data to the hive - $f3->set('', $variable)
        $f3->set('role', $role);
        $f3->set('hero1', $hero1);
        $f3->set('hero2', $hero2);
        $f3->set('hero3', $hero3);

        //if valid add to session (valid form) set session to variable
        //redirect to summary page
        if (validForm3()) {

            $user = $_SESSION['user'];

            $user->setRole($role);

            $heroes = array();

            if ($hero1 != '') {
                $heroes[] = $hero1;
            }
            if ($hero2 != '') {
                $heroes[] = $hero2;
            }
            if ($hero3 != '') {
                $heroes[] = $hero3;
            }

            $user->setHeroes($heroes);

            //Insert the PremiumUser into the db
            $f3->get('db')->insertUser($user);

            //Redirect to summary
            $f3->reroute('/summary');
        }
    }

    $view = new Template();
    echo $view->render('views/heroes.html');
});

//Define route to the registration summary page
$f3->route('GET|POST /summary', function($f3)
{
    global $db;

    $seshUser = $_SESSION['user'];
    //var_dump($seshUser);

    //view the user info in the database
    //$theUser = $db->selectUser($seshUser);    //FIXME it doesn't like this <--------------

    //set the hive
    //$f3->set('theUser', $theUser);


    $view = new Template();
    echo $view->render('views/summary.html');
});

//Define route to the user login page
$f3->route('GET|POST /login', function()
{
    //TODO: need to do login page
    //get data from form -  $variable = $_POST['']

    //add data to the hive - $f3->set('', $variable)

    //if valid add to session (valid login form) set session to variable
    //redirect to dashboard page

    $view = new Template();
    echo $view->render('views/login.html');
});

//Define route to the user dashboard page
$f3->route('GET|POST /dashboard', function() {
    //TODO: need to do dashboard page
    //TODO: assemble list items, form buttons? probably a good idea
    $view = new Template();
    echo $view->render('views/dashboard.html');
});

//Run Fat-free
$f3->run();