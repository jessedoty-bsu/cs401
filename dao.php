<?php

class Dao {

    //Since repo is public, I changed this to dummy credentials
    private $host = "localhost";
    private $db = "database";
    private $user = "user";
    private $pass = "password";

    public function getConnection () {
     return
          new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user,
          $this->pass);
    }

    public function new_user($email, $password) {
      //sanitize data and add user to the db
    }

}