<?php
include_once("../../server/db_manager.php");
include_once("../../server/session_manager.php");
include_once("../../server/models/comment.php");

$dbMan = DBManager::getInstance();
if (isset($_POST['delete-article'])) {
    $dbMan->deleteObject($_POST['delete-article'],"Article");
    header("Location: ".SessionManager::BASE_URL."admin");
} else {
    header("Location: ".SessionManager::BASE_URL."admin");
}

?>