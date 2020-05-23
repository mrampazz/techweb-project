<?php
include_once("../../server/session_manager.php");
include_once("../../server/db_manager.php");
include_once("../../server/models/models.php");
$output = file_get_contents("../html/profile.html");

$dbMan = DBManager::getInstance();

if(!SessionManager::isUserLogged()){
  header("Location: ".SessionManager::BASE_URL."home");
}

if(isset($_SESSION['error-message'])) {
  $output = str_replace("<div class='margin-top-2 hidden'>","<div class='margin-top-2' tabindex='0'>",$output);
  $output = str_replace("{error-message}",$_SESSION['error-message'],$output);
}

$userId = null;
$userId = SessionManager::getUserId();
$user = User::getUser($userId);

$output = str_replace("{surname}", $user->surname,$output);
$output = str_replace("{name}", $user->name,$output);
$output = str_replace("avatar_url", "../public/".$user->avatarUrl,$output);
$output = str_replace("{email}", $user->email,$output);
$output = str_replace("{username}",$user->username,$output);

unset($_SESSION['error-message']);
echo $output;

?>