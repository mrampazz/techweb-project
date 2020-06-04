<?php
include_once("../../../database/db_manager.php");
include_once("../../../database/session_manager.php");
include_once("../../server/models/comment.php");

$dbMan = DBManager::getInstance();

$commentUserId = Comment::getUserIdFor($_POST['comment-id'])[0]->user_id;
if (SessionManager::getUserId() == $commentUserId || SessionManager::userCanPublish()){
    $_SESSION['is-comment-deleted'] = $dbMan->deleteObject($_POST['comment-id'], "Comment");
    header("Location: ".SessionManager::BASE_URL."article"."&articleId=".$_GET["articleId"]); 
}
else{
    header("Location: ".SessionManager::BASE_URL."no-permissions");
}

?>