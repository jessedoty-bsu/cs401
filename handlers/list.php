<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . "/dao.php";
$user = $_SESSION['user'];

$dao = new Dao();
if(isset($_POST['new_list_title'])) {
    $dao->createList($user, $_POST['new_list_title']);
}
elseif(isset($_POST['new_item_content'])) {
    $dao->addItem($_POST['list_id'], $_POST['new_item_content']);
}
elseif(isset($_POST['item_id']) && isset($_POST['checked'])) {
    $dao->toggleChecked($_POST['item_id'], $_POST['checked']);
}
elseif(isset($_POST['list_id'])) {
    $newListId = $_POST['list_id'];
    foreach($_SESSION['lists'] as $list) {
        if($list['list_id'] == $newListId) {
            $_SESSION['currentList'] = $list;
        }
    }
}
elseif(isset($_POST['share_list_id'])) {
    $dao->share($_POST['user'], $_POST['share_list_id']);
}
