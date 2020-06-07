<?php
include_once("../../server/session_manager.php");
include_once("../../server/db_manager.php");
include_once("../../server/utils.php");
include_once("../../server/models/models.php");

if (!SessionManager::userCanPublish()){
    header("Location: ".SessionManager::BASE_URL."no-permissions");
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isUpdateMode = isset($_GET['id']);
    $brand = Utils::validateInput($_POST["brand"]);
    $model = Utils::validateInput($_POST["model"]);
    $price = Utils::validateInput($_POST["price"]);
    $amazonLink = Utils::validateInput($_POST["amazon-link"]);
    $description = Utils::validateInput($_POST["description"]);
    $date = Utils::validateInput($_POST["date"]);
    $image="";
    setSessionVariables();

    if (checkParameters($brand, $model, $price, $date, $amazonLink, $description, $image, $isUpdateMode)) { // if true parameters are in the correct format -> try to login
        $article = new Article();
        $article->brand = $brand;
        $article->model = $model;
        $article->initialPrice = $price;
        $article->launchDate = validateDate($date);
        $article->link = $amazonLink;
        $article->content = $description;   
        $article->image = $image;
        
        if ($isUpdateMode) {
            // update
            $article->id = $_GET['id'];
            $_SESSION['updated-correctly'] = $article->updateInDB();
        } 
        else {
            // create new
            $_SESSION['inserted-correctly'] = $article->saveInDB();
        }
    }
    //success! redirect
    if (!empty($_SESSION['updated-correctly']) || !empty($_SESSION['inserted-correctly'])){
        Utils::unsetAll(array('brand','model','price','date','amazon-link','description'));
        header("Location: ".SessionManager::BASE_URL."admin");
        return;
    }

    //an error has occurred, redirect
    if ($isUpdateMode){
        header("Location: ".SessionManager::BASE_URL."modify-article&edit=true&id=".$_GET['id']);
    }
    else{
        header("Location: ".SessionManager::BASE_URL."add-article");
    }
}

// check data format -> return true if correct. Otherwise, return false and set errormessage
function checkParameters($brand, $model, $price, $date, $amazonLink, $description, &$image, $isUpdateMode){

    //first check image validity
    $tempImg = validateImage($isUpdateMode);
    if (is_null($tempImg))
        return false;
    else
        $image = $tempImg;

    if (empty($brand)) {
        $_SESSION['error-message'] = "Il campo \"marca\" non può essere vuoto.";
        return false;
    }
    if (empty($model)) {
        $_SESSION['error-message'] = "Il campo \"modello\" non può essere vuoto.";
        return false;
    }
    if (empty($price)) {
        $_SESSION['error-message'] = "Il campo \"prezzo di lancio\" non può essere vuoto.";
        return false;
    } 
    else if(!preg_match("/^\d+(\.\d{1,2})?$/",$price)){
        $_SESSION['error-message'] = "Controlla il prezzo di lancio! Il campo deve contenere un valore numerico valido.";
        return false;
    }
    if (empty($date)) {
        $_SESSION['error-message'] = "Il campo \"data di lancio\" non può essere vuoto.";
        return false;
    }
    else if(!preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d$/",$date) || !Utils::isValidDate($date)){
        $_SESSION['error-message'] = "Controlla la data di lancio! La data inserita non risulta valida o non segue il formato dd-mm-yyyy.";
        return false;
    }
    if (empty($amazonLink)) {
        $_SESSION['error-message'] = "Il campo \"link amazon\" non può essere vuoto.";
        return false;
    }
    else if(!preg_match("/^(?:https?:\/\/)?(?:www\.)?(?:amazon\..*\/.*|amzn\.com\/.*|amzn\.to\/.*)$/",$amazonLink)){
        $_SESSION['error-message'] = "Controlla il link! Il link da te inserito non è un link Amazon valido.";
        return false;
    }

    if (empty($description)) {
        $_SESSION['error-message'] = " Il campo \"descrizione\" non può essere vuoto. ";
        return false;
    }

    return true;
}

function validateImage($isUpdateMode){
    //check image upload
    $target_dir = "../assets/img/articles/";
    if ($_FILES["file-upload"]["name"] != null) {
        $upload_result = Utils::uploadImage($target_dir, $_FILES["file-upload"]);
        if ($upload_result["success"] === false) {
            $_SESSION['error-message'] = $upload_result["error"];
            return null;
        }
        else{
            return $upload_result["url"];
        }
    }
    else if ($isUpdateMode){
        $article = Article::fetch($_GET['id']);
        $image = $article->image;
        if(!empty($image)){
            return $image;
        }
    }
    return "default.png";
}

//from dd-mm-yyyy to yyyy-mm-dd
function validateDate($date){
    $splittedDate = explode('-',$date);
    return Utils::createDate($splittedDate[0],$splittedDate[1],$splittedDate[2]);
}

function setSessionVariables(){
    $_SESSION['brand'] = Utils::validateInput($_POST["brand"]);
    $_SESSION['model'] = Utils::validateInput($_POST["model"]);
    $_SESSION['price'] = Utils::validateInput($_POST["price"]);
    $_SESSION['amazon-link'] = Utils::validateInput($_POST["amazon-link"]);
    $_SESSION['description'] = Utils::validateInput($_POST["description"]);
    $_SESSION['date'] = Utils::validateInput($_POST["date"]);
}

?>
