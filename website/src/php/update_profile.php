<?php
include_once("../../../database/session_manager.php");
include_once("../../../database/db_manager.php");
include_once("../../server/utils.php");
include_once("../../server/models/models.php");

//user not logged -> redirect to login page
if (!SessionManager::isUserLogged()) {
  header("Location: ../php/login.php");
  return;                               
}

$name = Utils::validateInput($_POST['name']);
$surname = Utils::validateInput($_POST['surname']); 

// get current user info
$userId = SessionManager::getUserId();
$user = User::getUser($userId);

//check image upload
$target_dir = "../assets/img/avatars/";
if ($_FILES["file-upload"]["name"] != null) {
  $upload_result = Utils::uploadImage($target_dir, $_FILES["file-upload"]);
  if ($upload_result["success"] === false) {
    $_SESSION['error-message'] = $upload_result["error"];
  }
  else{
    $user->avatarUrl = $upload_result["url"];
  }
}

//update the current user data only if the one provided is valid
if (isValidSurname($surname)){
  $user->surname = $surname;
}
if (isValidName($name)){
  $user->name = $name;
}

$user->saveUser();
if (!isset($_SESSION['error-message'])){
  $_SESSION['updated-correctly'] = "true";
}
header("Location: ".SessionManager::BASE_URL."profile");


// check data validity functions
function isValidName($nameToCheck){
  if (empty($nameToCheck)) {
    $_SESSION['error-message'] = "Inserisci il nome e richiedi l'aggiornamento del profilo. In caso contrario verrà ripristinato il nome precedente.";
    $_SESSION['name'] = $nameToCheck;
    return false;
  }
  else if(!preg_match("/^[a-zA-Z ]{1,16}$/",$nameToCheck)){
    $_SESSION['error-message'] = "Controlla il nome! Il campo dev'essere composto solamente da lettere. Quando hai finito richiedi l'aggiornamento del profilo. In caso contrario verrà ripristinato il nome precedente.";
    $_SESSION['name'] = $nameToCheck;
    return false;
  }
  return true;
}

function isValidSurname($surnameToCheck){
  if (empty($surnameToCheck)) {
    $_SESSION['error-message'] = "Inserisci il cognome e richiedi l'aggiornamento del profilo. In caso contrario verrà ripristinato il cognome precedente.";
    $_SESSION['surname'] = $surnameToCheck;
    return false;
  } 
  else if(!preg_match("/^[a-zA-Z ]{1,16}$/",$surnameToCheck)){
    $_SESSION['error-message'] = "Controlla il cognome! Il campo dev'essere composto solamente da lettere. Quando hai finito richiedi l'aggiornamento del profilo. In caso contrario verrà ripristinato il cognome precedente.";
    $_SESSION['surname'] = $surnameToCheck;
    return false;
  }
  return true;
}
?>