<?php
include_once("../src/controllers/utils.php");
include_once("../src/session_manager.php");
include_once("../src/db_manager.php");
include_once("../src/models/models.php");

// this controller is the target of the update user form action
if (!SessionManager::isUserLogged()) {
    echo "Error, no user logged";
    return;
}

// paremeters to get: name, surname, email, avatar(image)
if (!isset($_POST["name"]) || !isset($_POST["surname"])) {
    echo "Error, Missing parameters";
    return;
}

$name = $_POST["name"]; $surname = $_POST["surname"]; 
if (!(isset($name) && !empty($name))) {
    echo "Error, invalid name";
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

header("Location: ".SessionManager::BASE_URL."profilo");

?>