<?php
include_once("../../server/session_manager.php");
include_once("../../server/db_manager.php");
include_once("../../server/utils.php");
include_once("../../server/models/models.php");

// IS USER LOGGED? 

if (!SessionManager::isUserLogged()) {
    echo "Error, no user logged";
    return;
}

if (!isset($_POST["comment"])) {
    echo "Error, Missing comment";
    return;
}

$content = Utils::validateInput($_POST["comment"]);

if (!(isset($content) && !empty($content))) {
    echo "Error, invalid comment";
    return;
}

// SAVE COMMENT
$userId = SessionManager::getUserId();
$movieId=$_POST["movieId"];

Comment::createComment($userId,$movieId,htmlentities($content, ENT_QUOTES)); 

header("Location: ".SessionManager::BASE_URL."dettaglio"."&movieId=".$movieId);



?>

