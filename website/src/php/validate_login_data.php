<?php
include_once("../../server/session_manager.php");
include_once("../../server/db_manager.php");
include_once("../../server/utils.php");
include_once("../../server/models/models.php");

// define session variables 
$_SESSION['login'] = false; //not logged by default
$_SESSION['error-message'] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = Utils::validateInput($_POST["username"]);
  $password = Utils::validateInput($_POST["password"]);
  $_SESSION['username'] = $username;

  if (checkParameters($username, $password, $errorMessage)) // if true parameters are in the correct format -> try to login
  {
    $man = DBManager::getInstance();
    $log = $man->login($username, $password);
    if ($log !== false) // se loggato
    {
      $_SESSION['login'] = true;
      userLoggedCorrectly(); 
    } else {
      $_SESSION['error-message'] = " autenticazione fallita.";
      header("Location: ../php/login.php");
    }
  }
  else{
    header("Location: ../php/login.php");
  }

}

// check data format -> return true if correct. Otherwise, return false and set errormessage
function checkParameters($username, $password, &$errorMessage)
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
