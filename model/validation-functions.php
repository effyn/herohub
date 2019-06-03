<?php
//Name: Alicia Buehner, Evan Wheeler
//Date: TODO: fill in due date
//Description: This file contains the validation functions for the...

//TODO: write validation functions...


/**
 * Checks to see that personal information form
 * is valid.
 *
 * @return boolean
 */
function validForm1()
{
    global $f3;
    $isValid = true;

    //check if each of the fields are valid for account form
    if (!validName($f3->get('fName'))) {
        $isValid = false;
        $f3->set("errors['first']", 'Please enter a your first name');
    }

    if (!validName($f3->get('lName'))) {
        $isValid = false;
        $f3->set("errors['last']", 'Please enter your last name');
    }

    //TODO if for battletag

    if (!validEmail($f3->get('email'))) {
        $isValid = false;
        $f3->set("errors['email']", 'Please enter a valid email');
    }

    //TODO valid password

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

//TODO: valid battle tag

/**
 * This function validates that email address is valid value.
 *
 * @param String 4email An email to validate
 * @return boolean
 */
function validEmail($email)
{
    //return true if valid email and not empty
    return filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email);
}

//TODO: valid password reusable for both fields additionally need to check if both are equal to each other

function validPassword($password) {

    $regexPattern;

    if (preg_match()) {

    }
}



