<?php
include_once("../../server/session_manager.php");
include_once("../../server/db_manager.php");
include_once("../../server/utils.php");
include_once("../../server/models/models.php");

$content = Utils::validateInput($_POST['comment-input']);
$_SESSION['comment'] = $content;

if (!SessionManager::isUserLogged()) {
    header("Location: ".SessionManager::BASE_URL."login");
    return;
}

if (!isset($content)) {
    echo "Error, Missing comment";
    return;
}

if (!(isset($content) && !empty($content))) {
    echo "Error, invalid comment";
    return;
}

// SAVE COMMENT
$userId = SessionManager::getUserId();
$articleId=$_POST["articleId"];

Comment::createComment($userId,$articleId,htmlentities($content, ENT_QUOTES)); 

header("Location: ".SessionManager::BASE_URL."article-page"."&articleId=".$articleId);
?>

