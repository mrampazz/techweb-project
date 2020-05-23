<?php
include_once("../../server/utils.php");
include_once("../../server/session_manager.php");
include_once("../../server/db_manager.php");
include_once("../../server/models/models.php");

//user not logged -> redirect to login page
if (!SessionManager::isUserLogged()) {
  header("Location: ../php/login.php");
  return;                               
}

$name = $_POST['name'];
$surname = $_POST['surname']; 

// get current user info
$userId = SessionManager::getUserId();
$user = User::getUser($userId);

//updates the current data only if those provided are valid
if (isValidName($name)){
  $user->name = $name;
}
if (isValidSurname($surname)){
  $user->surname = $surname;
}

// good to go on these parameters, now check image upload
$target_dir = "../assets/img/avatars/";
if ($_FILES["avatar"]["name"] != null) {
  $upload_result = Utils::uploadImage($target_dir, $_FILES["avatar"]);
  if ($upload_result["success"] === false) {
    $_SESSION['error-message'] = $upload_result["error"];
  }
  else{
    $user->avatarUrl = "/".$upload_result["url"];
  }
}

$user->saveUser(); 
header("Location: ".SessionManager::BASE_URL."profile");


// check data validity functions
function isValidName($nameToCheck){
  if (empty($nameToCheck)) {
    $_SESSION['error-message'] = "inserisci il nome e richiedi l'aggiornamento del profilo. In caso contrario verrà ripristinato il nome precedente.";
    return false;
  }
  else if(!preg_match("/^[a-zA-Z ]{1,16}$/",$nameToCheck)){
    $_SESSION['error-message'] .= " controlla il nome! Il campo dev'essere composto solamente da lettere. Quando hai finito richiedi l'aggiornamento del profilo. In caso contrario verrà ripristinato il nome precedente.";
    return false;
  }
}

function isValidSurname($surnameToCheck){
  if (empty($surnameToCheck)) {
    $_SESSION['error-message'] = "inserisci il cognome e richiedi l'aggiornamento del profilo. In caso contrario verrà ripristinato il cognome precedente.";
    return false;
  } 
  else if(!preg_match("/^[a-zA-Z ]{1,16}$/",$surnameToCheck)){
    $_SESSION['error-message'] .= " controlla il cognome! Il campo dev'essere composto solamente da lettere. Quando hai finito richiedi l'aggiornamento del profilo. In caso contrario verrà ripristinato il cognome precedente.";
    return false;
  }
}
?>