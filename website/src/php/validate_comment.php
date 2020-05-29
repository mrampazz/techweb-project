<?php
include_once("../../../database/session_manager.php");
include_once("../../../database/db_manager.php");
include_once("../../server/utils.php");
include_once("../../server/models/models.php");

$articleId = $_POST["articleId"];
$content = Utils::validateInput($_POST['comment-input']);
$_SESSION['comment'] = $content;


if (!SessionManager::isUserLogged()) {
    header("Location: ".SessionManager::BASE_URL."login");
    return;
}

if (empty($content)) {
    $_SESSION['error-message'] = "il commento non può essere vuoto!";
    header("Location: ".SessionManager::BASE_URL."article"."&articleId=".$articleId);
    return;
}

// SAVE COMMENT
$userId = SessionManager::getUserId();

Comment::createComment($userId,$articleId,htmlentities($content, ENT_QUOTES)); 

header("Location: ".SessionManager::BASE_URL."article"."&articleId=".$articleId);
?>

