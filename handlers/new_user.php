<?php
session_start();
require_once "/../dao.php";
$dao = new Dao();

$email = (isset($_POST["signup-email"])) ? $_POST["signup-email"] : "";
$pass = (isset($_POST["signup-password"])) ? $_POST["signup-password"] : "";
$conf_pass = (isset($_POST["confirm-signup-password"])) ? $_POST["confirm-signup-password"] : "";
$errors = array();
$presets = array();

/*
 * Validate email and password given.
 * If there are errors redirect them back to the signup page, otherwise create the new user and send them to the logged in page (main.php)
 */
validate_email($email);
validate_passwords($pass, $conf_pass);

if(!empty($errors)) {
    //There was an error so save information the user entered
    if(strlen($email) != 0) $presets['email'] = htmlspecialchars($email);
    $_SESSION['presets'] = $presets;

    //Store errors
    $_SESSION['errors'] = $errors;

    header('Location: ../signup.php');
}
else {
    $dao->new_user($email, $pass);
    unset($_SESSION['errors']);
    $_SESSION['user'] = $email;
    $_SESSION['access'] = true;
    header('Location: ../main.php');
}

/*
 * Validates email given is valid
 */
function validate_email($email) {
    global $errors;

    //Email must have been given
    if(strlen($email) != 0) {
        //Email must match a general email format
        if(preg_match("/^.+@.+\..[A-Za-z]{1,5}$/", $email)) {
            unset($_SESSION['errors']['email']);
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
    global $errors;

    //Password was given
    $len = strlen($pass);
    if($len != 0) {
        //Password meets requirement of being 6 characters long
        if($len >= 6) {
            //Both passwords match
            if($pass === $conf_pass) {
                unset($_SESSION['errors']['password']);
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
