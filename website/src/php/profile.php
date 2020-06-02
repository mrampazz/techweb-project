<?php
$dbMan = DBManager::getInstance();

if(!SessionManager::isUserLogged()){
  header("Location: ".SessionManager::BASE_URL."login");
  return;
}

if(isset($_SESSION['error-message']) && !empty($_SESSION['error-message'])) {
  $page = file_get_contents("../html/message-box.html");
  $output = str_replace("{message-box}",$page,$output);
  $output = str_replace("{message-box-class}","error-message-box",$output);
  $output = str_replace("{message-box-title}","Errore",$output);
  $output = str_replace("{message-box-text}",$_SESSION['error-message'],$output);
  unset($_SESSION['error-message']);
}
else if(isset($_SESSION['updated-correctly'])){
  $page = file_get_contents("../html/message-box.html");
  $output = str_replace("{message-box}",$page,$output);
  $output = str_replace("{message-box-class}","success-message-box",$output);
  $output = str_replace("{message-box-title}","Profilo aggiornato!",$output);
  $output = str_replace("{message-box-text}","Tutti i tuoi dati sono stati correttamente aggiornati.",$output);
  unset($_SESSION['updated-correctly']);
}
else{
  $output = str_replace("{message-box}","",$output);
}

$userId = SessionManager::getUserId();
$user = User::getUser($userId);

//restore surname and/or name from session variables (these are set if an error has occurred)
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


?>