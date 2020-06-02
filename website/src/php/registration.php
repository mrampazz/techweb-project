<?php

if(isset($_SESSION['error-message']) && isset($_SESSION['registration']) && !$_SESSION['registration']) {
    $page = file_get_contents("../html/message-box.html");
    $output = str_replace("{message-box}",$page,$output);
    $output = str_replace("{message-box-class}","error-message-box",$output);
    $output = str_replace("{message-box-title}","Credenziali invalide",$output);
    $output = str_replace("{message-box-text}","Controlla le tue credenziali e riprova ad effettuare la registrazione: ".$_SESSION['error-message'],$output);
}
else{
    $output = str_replace("{message-box}","",$output);
}
/* check if session variables are set
    true -> re-assign values (prevents the user from re-entering values)
    false -> set empty string values
 */
if (isset($_SESSION['username'])){
    $output = str_replace("{username}",$_SESSION['username'],$output);
}
else{
    $output = str_replace("{username}","",$output);
}
if (isset($_SESSION['name'])){
    $output = str_replace("{name}",$_SESSION['name'],$output);
}
else{
    $output = str_replace("{name}","",$output);
}
if (isset($_SESSION['surname'])){
    $output = str_replace("{surname}",$_SESSION['surname'],$output);
}
else{
    $output = str_replace("{surname}","",$output);
}
if (isset($_SESSION['email'])){
    $output = str_replace("{email}",$_SESSION['email'],$output);
}
else{
    $output = str_replace("{email}","",$output);
}

Utils::unsetAll(array('username','name','surname','email','error-message'));
?>