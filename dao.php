<?php

class Dao {
    /*
  private $host = "localhost";
  private $db = "jotrecord";
  private $user = "user";
  private $pass = "password"; */

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
                          (:email, :password)";
      $q = $cxn->prepare($newUserQuery);
      $q->bindParam(":email", $email);
      $q->bindParam(":password", $password);

      //Default profile picture
      /*
       * This works locally but kills heroku for a bit if it's executed. Removing it for now.
      $imgPath = "/images/avatar.png";
      $blob = fopen($imgPath, 'rb');
      $q->bindParam(":prof_pic", $blob, PDO::PARAM_LOB);
      */

      $q->execute();
  }
}