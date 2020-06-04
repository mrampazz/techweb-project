<?php
$article = null;
$id = null;
if (isset($_GET['id'])) {
    if ($_GET['id']) {
        $id = $_GET['id'];
    }
}
$article = Article::fetch($id);
if ($article) {
    if(isset($_SESSION['error-message'])) {
        $page = file_get_contents("../html/message-box.html");
        $output = str_replace("{message-box}",$page,$output);
        $output = str_replace("{message-box-class}","error-message-box",$output);
        $output = str_replace("{message-box-title}","Errore modifica telefono",$output);
        $output = str_replace("{message-box-text}",$_SESSION['error-message'],$output);
        unset($_SESSION['error-message']);
    }
    else{
        $output = str_replace("{message-box}","",$output);
    }

    $output = str_replace("{edit}", "Modifica", $output);

    //restore previous user input in case of error, else restore data from db
    if (isset($_SESSION['brand'])){
        $output = str_replace("{brand}",$_SESSION['brand'], $output);
    }
    else{
        $output = str_replace("{brand}", $article->brand, $output);
    }
    if (isset($_SESSION['model'])){
        $output = str_replace("{model}",$_SESSION['model'], $output);
    }
    else{
        $output = str_replace("{model}", $article->model, $output);
    }
    if (isset($_SESSION['price'])){
        $output = str_replace("{price}",$_SESSION['price'], $output);
    }
    else{
        $output = str_replace("{price}", $article->initialPrice, $output);
    }
    if (isset($_SESSION['date'])){
        $output = str_replace("{date}",$_SESSION['date'], $output);
    }
    else{
        $output = str_replace("{date}", date("d-m-Y", strtotime($article->launchDate)), $output);
    }
    if (isset($_SESSION['amazon-link'])){
        $output = str_replace("{amzn-link}",$_SESSION['amazon-link'], $output);
    }
    else{
        $output = str_replace("{amzn-link}", $article->link, $output);
    }
    if (isset($_SESSION['description'])){
        $output = str_replace("{desc}",$_SESSION['description'], $output);
    }
    else{
        $output = str_replace("{desc}", $article->content, $output);
    }
    Utils::unsetAll(array('brand','model','price','date','amazon-link','description'));

    $output = str_replace("article-image-url", "../assets/img/articles/".$article->image, $output);
    $output = str_replace("validate-form-url", "../php/validate_admin_form.php?id=".$id, $output);
}
else{ //no article with this id
    header("Location:".SessionManager::BASE_URL."404");
}
?>
