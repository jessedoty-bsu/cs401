<?php
session_start();
require_once "../dao.php";
$dao = new Dao();


$email = (isset($_POST["login-email"])) ? $_POST["login-email"] : "";
$pass = (isset($_POST["login-password"])) ? $_POST["login-password"] : "";

if(!$dao->validate_user($email, $pass)) {
    $_SESSION['invalid'] = "Invalid email or password";

    //We are a directory down, thus .. must prefix the caller's location. Assuming all callers are in the top level directory
    $dir = ".." . $_SESSION['page'];
    header("Location: $dir");
}
else {
    unset($_SESSION['invalid']);
    $_SESSION['user'] = $email;
    $_SESSION['access'] = true;
    header("Location: ../main.php");
}