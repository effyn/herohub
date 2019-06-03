<?php
//Name: Alicia Buehner, Evan Wheeler
//Date: TODO: fill in due date
//Description: This file contains the validation functions for the...

//TODO: write validation functions...

/**
 * Checks to see that account registration form
 * is valid.
 *
 * @return boolean
 */
function validForm1()
{
    global $f3;
    $isValid = true;

    //check if each of the fields are valid for account form
    if (!validName($f3->get('fname'))) {
        $isValid = false;
        $f3->set("errors['first']", 'Please enter a your first name');
    }

    if (!validName($f3->get('lname'))) {
        $isValid = false;
        $f3->set("errors['last']", 'Please enter your last name');
    }

    if(!validBattleTag($f3->get('battletag'))) {
        $isValid = false;
        $f3->set("errors['battletag']", 'Please enter a valid BattleTag');
    }

    if (!validEmail($f3->get('email'))) {
        $isValid = false;
        $f3->set("errors['email']", 'Please enter a valid email');
    }

    //check if first pw is valid
    if (!validPassword($f3->get('password'))) {
        $f3->set("errors['password']", 'Please enter a valid password');
    }

    //check if second password matches first password
    if ($f3->get('password') != $f3->get('password2')) {
        $f3->set("errors['password2']", 'Passwords did not match');
    }

    return $isValid;
}

/**
 * Checks to see that a string is all alphabetic
 * and contains a value.
 *
 * @param String $name A string to validate
 * @return boolean
 */
function validName($name)
{
    //return true if not empty and all alphabetic
    return !empty($name) && ctype_alpha($name);
}

/**
 * This function validates that BattleTag is a valid value.
 *
 * @param String BattleTag A BattleTag to validate
 * @return boolean
 */
function validBattleTag($battleTag)
{
    //battle tag regex
    $regexPattern = "/^[\p{L}\p{Mn}][\p{L}\p{Mn}0-9]{2,11}#[0-9]{4,5}+$/u";
    return preg_match($regexPattern, $battleTag);
}

/**
 * This function validates that email address is valid value.
 *
 * @param String email An email to validate
 * @return boolean
 */
function validEmail($email)
{
    //return true if valid email and not empty
    return filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email);
}

/**
 * This function validates that a password is valid value.
 *
 * @param String password A password to validate
 * @return boolean
 */
function validPassword($password)
{
    // alphanumeric, 8-20 chars long, no spaces or special chars
    $regexPattern = "/^[a-zA-Z0-9]{8, 20}$/";
    return preg_match($regexPattern, $password);
}




