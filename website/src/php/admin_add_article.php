<?php

if(isset($_SESSION['error-message'])) {
    $page = file_get_contents("../html/message-box.html");
    $output = str_replace("{message-box}",$page,$output);
    $output = str_replace("{message-box-class}","error-message-box",$output);
    $output = str_replace("{message-box-title}","Errore inserimento telefono",$output);
    $output = str_replace("{message-box-text}",$_SESSION['error-message'],$output);
    unset($_SESSION['error-message']);
}
else{
    $output = str_replace("{message-box}","",$output);
}
$output = str_replace("{edit}", "Inserimento", $output);
$output = str_replace("{brand}", "", $output);
$output = str_replace("{model}", "", $output);
$output = str_replace("{price}", "", $output);
$output = str_replace("{amzn-link}", "", $output);
$output = str_replace("{desc}", "", $output);
$output = str_replace("{date}", "", $output);
$output = str_replace("article-image-url", "../assets/img/articles/default.png", $output);
$output = str_replace("validate-form-url", "../php/validate_admin_form.php", $output);
?>