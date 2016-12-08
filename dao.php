<?php

class Dao {
    /*
  private $host = "localhost";
  private $db = "jotrecord";
  private $user = "user";
  private $pass = "password";*/


  private $host = "us-cdbr-iron-east-04.cleardb.net";
  private $db = "heroku_4d19e91f7d43b1a";
  private $user = "b3a51b586d0bd2";
  private $pass = "a7e9651e";

  public function getConnection () {
    return
      new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
  }


  /*
   * Add  new user to database
   */
  public function new_user($email, $password) {
      $cxn = $this->getConnection();
      $newUserQuery = "INSERT INTO person 
                          (email, password, prof_pic)
                          VALUES 
                          (:email, :password, :prof_pic)";
      $q = $cxn->prepare($newUserQuery);
      $q->bindParam(":email", $email);
      //Encrypt password. Default algorithm is bcrypt and the function automatically salts it
      $encryptedPass = password_hash($password, PASSWORD_DEFAULT);
      $q->bindParam(":password", $encryptedPass);

      //Default profile picture
      $imgPath = "/images/avatar.png";
      $blob = fopen($imgPath, 'rb');
      $q->bindParam(":prof_pic", $blob, PDO::PARAM_LOB);

      $q->execute();
  }

  /*
   * Validate user credentials
   *
   * @return true if user exists and password given is correct, false otherwise
   */
  public function validate_user($email, $password) {
      $cxn = $this->getConnection();
      $validate_user = "SELECT email, password FROM person WHERE email = :email";

      $q = $cxn->prepare($validate_user);
      $q->bindParam(":email", $email);
      $q->execute();

      $row = $q->fetch();

      //Does user exist
      if(!$row) {
          return false;
      }

      //Did they provide the correct password
      //Check the password given against the stored hash
      if(password_verify($password, $row['password'])) {
         return true;
      }
      else {
          return false;
      }
  }


  /*
   * Get all lists related to a user sorted by most recent list created, with their items sorted by oldest to newest
   *
   * @param $user - the user's email address
   * @return all lists returned by the query
   */
  public function getAllLists($user) {
      $cxn = $this->getConnection();
      $listsQuery = "SELECT * 
                      FROM person AS p 
                      JOIN person_has_list AS phl ON p.person_id = phl.person_id
                      JOIN list AS l ON phl.list_id = l.list_id
                      WHERE p.email = :email
                      ORDER BY l.creation_date DESC;";

      $q = $cxn->prepare($listsQuery);
      $q->bindParam(":email", $user);
      $q->execute();

      return $q->fetchAll();
  }

  /*
   * Get all items for a given list
   *
   * @param $listID - id of list
   * @return all items returned by the query
   */
  public function getListItems($listID) {
     $cxn = $this->getConnection();
     $listQuery = "SELECT *
                    FROM list AS l 
                    JOIN list_item AS li ON l.list_id = li.list_id
                    WHERE l.list_id = :listID
                    ORDER BY li.creation_date ASC;";

     $q = $cxn->prepare($listQuery);
      $q->bindParam(":listID", $listID);
     $q->execute();

      return $q->fetchAll();
  }

  /*
   * Create list linked to the user given
   *
   * @param $user - user's email who is creating the list
   * @param $title - title of the new list
   */
  public function createList($user, $title) {
      $cxn = $this->getConnection();

      //Get person_id for the given user
      $idQuery = "SELECT person_id FROM person WHERE email = :email";
      $q = $cxn->prepare($idQuery);
      $q->bindParam(":email", $user);
      $q->execute();
      $fetchedUser = $q->fetch();
      $userID = $fetchedUser['person_id'];

      //Insert list into database
      $listQuery = "INSERT INTO list (title) VALUE (:title);";
      $q = $cxn->prepare($listQuery);
      $q->bindParam(":title", $title);
      $q->execute();
      $newListID = $cxn->lastInsertId();


      //Build reference between the user and new list
      $personQuery = "INSERT INTO person_has_list (person_id, list_id) VALUE (:person_id, :list_id);";
      $q = $cxn->prepare($personQuery);
      $q->bindParam(":person_id", $userID);
      $q->bindParam(":list_id", $newListID);
      $q->execute();

  }

  /*
   * Add a list item to a given list
   *
   * @param listID - id of the list we're adding to
   * @param itemContent - title of the new list item
   */
  public function addItem($listID, $itemContent) {
      $cxn = $this->getConnection();
      $itemQuery = "INSERT INTO list_item (content, list_id) VALUES (:content, :listID);";

      $q = $cxn->prepare($itemQuery);
      $q->bindParam(":content", $itemContent);
      $q->bindParam(":listID", $listID);

      $q->execute();
  }

  /*
   * Toggle the status of checked for a given item
   *
   * @param itemID - id of item to be toggled
   * @param checked - current status of item
   */
  public function toggleChecked($itemID, $checked) {
      $cxn = $this->getConnection();

      //Toggle checked status of the item
      $checked = $checked ? 0:1;

      $itemQuery = "UPDATE list_item SET checked = :checked WHERE li_id = :itemID;";


      $q = $cxn->prepare($itemQuery);
      $q->bindParam(":checked", $checked);
      $q->bindParam(":itemID", $itemID);

      $q->execute();
  }


  public function share($user, $listID) {
      $cxn = $this->getConnection();

      //Get person_id for the given user
      $idQuery = "SELECT person_id FROM person WHERE email = :email";
      $q = $cxn->prepare($idQuery);
      $q->bindParam(":email", $user);
      $q->execute();
      $fetchedUser = $q->fetch();
      $userID = $fetchedUser['person_id'];
      //TODO return error to ajax that the user does not exist

      //Build reference between the user and new list
      $personQuery = "INSERT INTO person_has_list (person_id, list_id) VALUE (:person_id, :list_id);";
      $q = $cxn->prepare($personQuery);
      $q->bindParam(":person_id", $userID);
      $q->bindParam(":list_id", $listID);
      $q->execute();
  }
}