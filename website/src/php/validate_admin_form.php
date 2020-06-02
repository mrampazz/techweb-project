<?php
include_once("../../../database/session_manager.php");
include_once("../../../database/db_manager.php");
include_once("../../server/utils.php");
include_once("../../server/models/models.php");

if (!SessionManager::userCanPublish()){
    header("Location: ".SessionManager::BASE_URL."no-permissions");
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = Utils::validateInput($_POST["brand"]);
    $model = Utils::validateInput($_POST["model"]);
    $price = Utils::validateInput($_POST["price"]);
    $date = Utils::validateInput($_POST["date"]);
    $amazonLink = Utils::validateInput($_POST["amazon-link"]);
    $description = Utils::validateInput($_POST["description"]);
    $image = validateImage();

    if (checkParameters($brand, $model, $price, $date, $amazonLink, $description)) { // if true parameters are in the correct format -> try to login
        $article = new Article();
        $article->brand = $brand;
        $article->model = $model;
        $article->initialPrice = $price;
        $article->launchDate = $date;
        $article->link = $amazonLink;
        $article->content = $description;
        $article->image = $image;

        if (!isset($_GET['id'])) {
            // create new
            $article->saveInDB();
            header("Location: ".SessionManager::BASE_URL."admin");
        } 
        else {
            // update
            $article->id = $_GET['id'];
            $article->updateInDB();
            header("Location: ".SessionManager::BASE_URL."modify-article&edit=true&id=".$_GET['id']);
        }
    }
    else{
        header("Location: ".SessionManager::BASE_URL."add-article");
    }
}

// check data format -> return true if correct. Otherwise, return false and set errormessage
function checkParameters($brand, $model, $price, $date, $amazonLink, $description){
    if (empty($brand)) {
        $_SESSION['error-message'] .= " il campo \"marca\" non può essere vuoto.";
        return false;
    }
    if (empty($model)) {
        $_SESSION['error-message'] .= " il campo \"modello\" non può essere vuoto.";
        return false;
    }
    if (empty($price)) {
        $_SESSION['error-message'] .= " il campo \"prezzo di lancio\" non può essere vuoto.";
        return false;
    } 
    else if(!preg_match("/^\d+(\.\d{1,2})?$/",$price)){
        $_SESSION['error-message'] .= " controlla il prezzo di lancio! Il campo deve contenere un valore numerico valido.";
        return false;
    }
    if (empty($date)) {
        $_SESSION['error-message'] .= " il campo \"data di lancio\" non può essere vuoto.";
        return false;
    }
    else if(!preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d$/",$date)){
        $_SESSION['error-message'] .= " controlla la data di lancio!. La data inserita non risulta valida o non segue il formato dd-mm-yyyy.";
        return false;
    }
    if (empty($amazonLink)) {
        $_SESSION['error-message'] .= " il campo \"link amazon\" non può essere vuoto.";
        return false;
    }
    else if(!preg_match("/^(?:https?:\/\/)?(?:www\.)?(?:amazon\..*\/.*|amzn\.com\/.*|amzn\.to\/.*)$/",$amazonLink)){
        $_SESSION['error-message'] .= " controlla il link! Il link da te inserito non è un link Amazon valido.";
        return false;
    }

    if (empty($description)) {
        $_SESSION['error-message'] .= " il campo \"descrizione\" non può essere vuoto. ";
        return false;
    }

    return true;
}

function validateImage(){
    //check image upload
    $target_dir = "../assets/img/articles/";
    if ($_FILES["file-upload"]["name"] != null) {
        $upload_result = Utils::uploadImage($target_dir, $_FILES["file-upload"]);
        if ($upload_result["success"] === false) {
            $_SESSION['error-message'] = $upload_result["error"];
        }
        else{
            return $upload_result["url"];
        }
    }
    return "default.png";
}
?>
