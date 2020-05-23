<?php
include_once("../../server/session_manager.php");
include_once("../../server/utils.php");
$output = file_get_contents("../html/login.html");

if(isset($_SESSION['error-message']) && isset($_SESSION['login']) && !$_SESSION['login']) {
    $output = str_replace("<div class='margin-top-2 hidden'>","<div class='margin-top-2' tabindex='0'>",$output);
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

Utils::unsetAll(array('username','error-message'));
echo $output;
?>