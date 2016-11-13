<?php
session_start();
require_once "../dao.php";
$dao = new Dao();

$email = (isset($_POST["signup-email"])) ? $_POST["signup-email"] : "";
$pass = (isset($_POST["signup-password"])) ? $_POST["signup-password"] : "";
$conf_pass = (isset($_POST["confirm-signup-password"])) ? $_POST["confirm-signup-password"] : "";
$errors = array();
$_SESSION['errors'] = $errors;

//If both are true sanitize the data and add the user to the database. Then redirect them to their logged in view
//Potentially set session variable with user credentials so lists can be loaded when they hit that page
if(validate_email($email) && validate_passwords($pass, $conf_pass)) {
   //$dao->new_user($email, $pass);
    header('Locaction: main.php');
}
else {
    header('Locaction: signup.php');
}

/*
 * Validates email given is valid
 */
function validate_email($email) {
    //Email must have been given
    if(strlen($email) != 0) {
        //Email must match a general email format
        if(preg_match("/^.+@.+\..[A-Za-z]{1,5}$/", $email)) {
            return true;
        }
        //Email does not meet validation requirements
        else {
            $errors['email'] = "Invalid email address";
            return false;
        }
    }
    //No password given
    else {
        $errors['email'] = "Enter a valid email";
        return false;
    }
}

/*
 * Validate password(s) given are valid and match
 */
function validate_passwords($pass, $conf_pass) {
    //Password was given
    if(($len = strlen($pass)) != 0) {
        //Password meets requirement of being 6 characters long
        if($len >= 6) {
            //Both passwords match
            if($pass === $conf_pass) {
                return true;
            } else {
                $errors['password'] = "Passwords do not match";
                return false;
            }
        } else {
            $errors['password'] = "Password must be at least 6 characters long";
            return false;
        }
    } else {
        $errors['password'] = "Enter a password";
        return false;
    }
}
/*
Check email is given
    Validate email

Check pass is given
    Check pass is 6 characters long
    Check confirm-pass is given
       Check it matches other pass

If all succeed, add new user to db and redirect to logged in page
*/


