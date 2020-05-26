<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
include_once("../../src/session_manager.php");

$userId = null;
if (SessionManager::isUserLogged()) {
    $userId = SessionManager::getUserId();
} else {
    // user not logged
    header("Location: ../php/login.php");
    return;
}

if (isset($_POST["redirectURL"]) && isset($_POST["articleID"]) && isset($_POST["vote"])) {
    $redirectURL = $_POST["redirectURL"];
    $articleID = $_POST["articleID"];
    $vote = $_POST["vote"];

    $article = Article::fetch($articleID);
    switch ($vote) {
        case "like":
            $article->addVote($userId, $articleID, 1);
        break;
        case "dislike":
            $article->addVote($userId, $articleID, 0);
        break;
    }

    header("Location: ".SessionManager::BASE_URL.$redirectURL);
} else {
    echo "Parametri incorretti";
}

?>