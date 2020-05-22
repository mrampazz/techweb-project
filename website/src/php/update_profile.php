<?php
include_once("../../server/utils.php");
include_once("../../server/session_manager.php");
include_once("../../server/db_manager.php");
include_once("../../server/models/models.php");

//user not logged
if (!SessionManager::isUserLogged()) {
  header("Location: ../php/login.php");
  return;
}

// paremeters to get: name, surname, email, avatar(image)
if (!isset($_POST["name"]) || !isset($_POST["surname"])) {
  $_SESSION['error-message'] = " riempi tutti i campi!";
  header("Location: ".SessionManager::BASE_URL."profile"); 
  return;
}

$name = $_POST["name"]; $surname = $_POST["surname"]; 
if (!(isset($name) && !empty($name))) {
  $_SESSION['error-message'] = " il nome inserito non è valido.";
  return;
}

// now save user data
$userId = SessionManager::getUserId();
$user = User::getUser($userId);
$user->name = $name;
$user->surname = $surname;

// good to go on these parameters, now check image upload
$target_dir = "assets/images/avatars/";
// print_r($_FILES["avatar"]);
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