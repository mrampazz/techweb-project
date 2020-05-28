<?php
include_once("../../../database/session_manager.php");
include_once("../../../database/db_manager.php");
include_once("../../server/models/models.php");

if (SessionManager::isUserLogged()) {
    $userId = SessionManager::getUserId();
} else {
    // user not logged
    header("Location: ".SessionManager::BASE_URL."login");
    return;
}

if (isset($_POST["vote"])) {
    $articleId = $_POST["articleID"];
    $vote = $_POST["vote"];
    $article = Article::fetch($articleId);
    switch ($vote) {
        case "like":
            $article->addVote($userId, $articleId, 1);
        break;
        case "dislike":
            $article->addVote($userId, $articleId, 0);
        break;
    }
    header("Location: ".SessionManager::BASE_URL."article"."&articleId=".$articleId);
} 
else {
    echo "Parametri incorretti";
}
?>