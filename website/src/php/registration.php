<?php
include_once("../../server/session_manager.php");
include_once("../../server/utils.php");
$output = file_get_contents("../html/registration.html");

if(isset($_SESSION['error-message']) && isset($_SESSION['registration']) && !$_SESSION['registration']) {
    $output = str_replace("<div class='margin-top-2 hidden'>","<div class='margin-top-2' tabindex='0'>",$output);
    $output = str_replace("{error-message}",$_SESSION['error-message'],$output);
}
/* controlla se sono impostate le variabili di sessione con i rispettivi valori 
 per ri-assegnare i rispettivi valori al campo value dell'input della form 
 (evitando il re-inserimento per l'utente)
 */
if (isset($_SESSION['username'])){
    $output = str_replace("'{username}'",$_SESSION['username'],$output);
}
else{
    $output = str_replace("'{username}'","",$output);
}
if (isset($_SESSION['name'])){
    $output = str_replace("'{name}'",$_SESSION['name'],$output);
}
else{
    $output = str_replace("'{name}'","",$output);
}
if (isset($_SESSION['surname'])){
    $output = str_replace("'{surname}'",$_SESSION['surname'],$output);
}
else{
    $output = str_replace("'{surname}'","",$output);
}
if (isset($_SESSION['email'])){
    $output = str_replace("'{email}'",$_SESSION['email'],$output);
}
else{
    $output = str_replace("'{email}'","",$output);
}

Utils::unsetAll(array('username','name','surname','email','error-message'));
echo $output;
?>