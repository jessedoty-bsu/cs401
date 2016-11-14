<?php
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once $_SERVER['DOCUMENT_ROOT'] . "../dao.php";
    $dao = new Dao();

    /*
     * Gets uesr's avatar from database
     */
    function get_avatar() {}
