<?php
if(isset($_SESSION['error-message']) && isset($_SESSION['login']) && !$_SESSION['login']) {
    $page = file_get_contents("../html/message-box.html");
    $output = str_replace("{message-box}",$page,$output);
    $output = str_replace("{message-box-class}","error-message-box",$output);
    $output = str_replace("{message-box-title}","Credenziali invalide",$output);
    $output = str_replace("{message-box-text}","Controlla le tue credenziali e riprova a fare l’accesso: ".$_SESSION['error-message'],$output);
}
else{
    $output = str_replace("{message-box}","",$output);
}
/* check if login session variable is set
    true -> re-assign value (prevents the user from re-entering the username)
    false -> set empty string value
*/
if (isset($_SESSION['username'])){
    $output = str_replace("{username}",$_SESSION['username'],$output);
}
else{
    $output = str_replace("{username}","",$output);
}

//if the user comes from the link of the article page then set url with the articleId (this will allow the redirection to the article)
if (isset($_GET['articleId'])){
    $output = str_replace("validate-login-url","../php/validate_login_data.php?articleId=".Utils::validateInput($_GET['articleId']),$output);
}
else{
    $output = str_replace("validate-login-url","../php/validate_login_data.php",$output);
}

Utils::unsetAll(array('username','error-message'));

?>