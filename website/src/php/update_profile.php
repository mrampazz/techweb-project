<?php
include_once("../../server/utils.php");
include_once("../../server/session_manager.php");
include_once("../../server/db_manager.php");
include_once("../../server/models/models.php");

//user not logged -> redirect to login page
if (!SessionManager::isUserLogged()) {
  //header("Location: ../php/login.php");
  //return;
}

$name = $_POST['name'];
$surname = $_POST['surname']; 

//check that all required values are set
if (empty($name)){
  $_SESSION['error-message'] = "inserisci il nome.";
  header("Location: ".SessionManager::BASE_URL."profile");
  return;
} 
if (empty($surname)) {
  $_SESSION['error-message'] = "inserisci il cognome.";
  header("Location: ".SessionManager::BASE_URL."profile");
  return;
}
 

// now save user data
$userId = SessionManager::getUserId();
$user = User::getUser($userId);
$user->name = $name;
$user->surname = $surname;

// good to go on these parameters, now check image upload
$target_dir = "assets/images/avatars/";
if ($_FILES["avatar"]["name"] != null) {
    $upload_result = Utils::uploadImage($target_dir, $_FILES["avatar"]);
    if ($upload_result["success"] === false) {
        echo $upload_result["error"];
        return;
    }
    $user->avatarUrl = "/".$upload_result["url"];
}

$user->saveUser();

header("Location: ".SessionManager::BASE_URL."profile");

?>