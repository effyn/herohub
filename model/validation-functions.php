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
 * Checks to see that playstyle preferences form
 * is valid.
 *
 * @return boolean
 */
function validForm2()
{
    global $f3;
    $isValid = true;


    if(!validBattleTag($f3->get('battletag'))) {
        $isValid = false;
        $f3->set("errors['battletag']", 'Please enter a valid BattleTag');
    }

    return $isValid;
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


//TODO: Everything below now goes with form 2 validation
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
