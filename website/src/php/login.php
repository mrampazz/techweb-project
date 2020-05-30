<?php
if(isset($_SESSION['error-message']) && isset($_SESSION['login']) && !$_SESSION['login']) {
    $output = str_replace("<div class=\"margin-top-2 hidden\">","<div class=\"margin-top-2\" tabindex=\"0\">",$output);
    $output = str_replace("{error-message}",$_SESSION['error-message'],$output);
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