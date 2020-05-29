<?php
$dbMan = DBManager::getInstance();

if(!SessionManager::isUserLogged()){
  header("Location: ".SessionManager::BASE_URL."home");
}

if(isset($_SESSION['error-message'])) {
  $output = str_replace("<div class=\"margin-top-2 hidden\">","<div class=\"margin-top-2\" tabindex=\"0\">",$output);
  $output = str_replace("{error-message}",$_SESSION['error-message'],$output);
}

$userId = SessionManager::getUserId();
$user = User::getUser($userId);

//restore surname and/or name (these are set if an error has occurred)
if(isset($_SESSION['name'])){
  $output = str_replace("{name}", $_SESSION['name'],$output);
  unset($_SESSION['name']);
}
else{
  $output = str_replace("{name}", $user->name,$output);
}
if (isset($_SESSION['surname'])){
  $output = str_replace("{surname}", $_SESSION['surname'],$output);
  unset($_SESSION['surname']);
}
else{
  $output = str_replace("{surname}", $user->surname,$output);
}

$output = str_replace("avatar-url","../assets/img/avatars/".$user->avatarUrl,$output);
$output = str_replace("{email}", $user->email,$output);
$output = str_replace("{username}",$user->username,$output);

unset($_SESSION['error-message']);


?>