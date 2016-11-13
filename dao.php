<?php

class Dao {

  private $host = "us-cdbr-iron-east-03.cleardb.net";
  private $db = "heroku_4d19e91f7d43b1a";
  private $user = "b3a51b586d0bd2";
  private $pass = "a7e9651e";

  public function getConnection () {
    return
      new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user,
          $this->pass);
  }


  /*
   * Add  new user to database
   */
  public function new_user($email, $password) {
      $cxn = $this->getConnection();
      $newUserQuery = "INSERT INTO person 
                          (email, password, prof_pic)
                          VALUES 
                          (:email, :password, LOAD_FILE(:prof_pic))";
      $q = $cxn->prepare($newUserQuery);
      $q->bindParam(":email", $email);
      $q->bindParam(":password", $password);
      $imgPath = "images/avatar.png";
      $q->bindParam(":prof_pic", $imgPath);

      $q->execute();
  }

}