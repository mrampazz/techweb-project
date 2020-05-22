<?php
include_once("../../server/session_manager.php");
include_once("../../server/db_manager.php");
include_once("../../server/models/models.php");

// define session variables and set to empty values
$_SESSION['login'] = false; //not logged by default
$_SESSION['error-message'] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = $_POST["username"];
  $password = $_POST["password"];
  $_SESSION['username'] = $username;

  if (checkParameters($username, $password, $errorMessage)) // se true, i dati sono nel formato corretto, provo ad autentificare l'utente
  {
    $man = DBManager::getInstance();
    $log = $man->login($username, $password);
    if ($log !== false) // se loggato
    {
      $_SESSION['login'] = true;
      userLoggedCorrectly(); 
    } else {
      $_SESSION['error-message'] = "le tue credenziali non sono valide.";
      header("Location: ../php/login.php");
    }
  }
  else{
    header("Location: ../php/login.php");
  }

}

function checkParameters($username, $password, &$errorMessage) // controlla il formato dei dati e ritorna true se sono corretti, altrimenti ritorna false e setta le stringhe di errore nella variabile errormessage
{
	if (empty($username)) {
	  $_SESSION['error-message'] .= " l'username è richiesto! ";
		return false;
  }
  else if(!preg_match("/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/",$username)){
    $_SESSION['error-message'] .= " controlla l'username! Il campo non può essere composto da caratteri speciali. ";
		return false;
  } 
	if (empty($password)) {
		$_SESSION['error-message'] .= " la password è richiesta! ";
		return false;
  }
	return true;
}

function logUser($username, $password)
{		
	// ask db manager if user credentials are correct
	return false;
}

function userLoggedCorrectly()
{
	// redirect to home and save session data
	header("Location: ".SessionManager::BASE_URL."home");
}

?>
