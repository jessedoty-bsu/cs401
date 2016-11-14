<?php
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once "../dao.php";
    $dao = new Dao();

    /*
     * Gets uesr's avatar from database
     */
    function get_avatar() {}
