<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . "/dao.php";
$user = $_SESSION['user'];

$dao = new Dao();
if(isset($_POST['new_list_title'])) {
    $dao->createList($user, $title);
}
elseif(isset($_POST['new_item_content'])) {
    $dao->addItem($_POST['list_id'], $_POST['new_item_content']);
}

class CheckList {

    private $dao;
    private $user;

    public function __construct($user) {
       $this->dao = new Dao();
       $this->user = $user;
    }


    public function getAllLists() {
        return $this->dao->getAllLists($this->user);
    }

    public function getListItems($listID) {
        return $this->dao->getListItems($listID);
    }
}