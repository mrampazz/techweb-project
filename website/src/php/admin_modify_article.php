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
    $output = str_replace("{brand}", $article->brand, $output);
    $output = str_replace("{model}", $article->model, $output);
    $output = str_replace("{price}", $article->initialPrice, $output);
    $output = str_replace("{amzn-link}", $article->link, $output);
    $output = str_replace("{desc}", $article->content, $output);
    $output = str_replace("{date}", date("d-m-Y", strtotime($article->launchDate)), $output);
    $output = str_replace("article-image-url", "../assets/img/articles/".$article->image, $output);
    $output = str_replace("validate-form-url", "../php/validate_admin_form.php?id=".$id, $output);
}
?>
