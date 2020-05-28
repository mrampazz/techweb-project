<?php
include_once("../../../database/session_manager.php");
include_once("../../../database/db_manager.php");
include_once("../../server/utils.php");
include_once("../../server/models/models.php");

// define session variables 
$_SESSION['login'] = false; //not logged by default
$_SESSION['error-message'] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = Utils::validateInput($_POST["username"]);
  $password = Utils::validateInput($_POST["password"]);
  $_SESSION['username'] = $username;

  if (checkParameters($username, $password)) // if true parameters are in the correct format -> try to login
  {
    $man = DBManager::getInstance();
    $log = $man->login($username, $password);
    if ($log !== false) // se loggato
    {
      $_SESSION['login'] = true;
      userLoggedCorrectly(); 
    } else {
      $_SESSION['error-message'] = " autenticazione fallita.";
      header("Location: ../php/layout.php?page=login");
    }
  }
  else{
    header("Location: ../php/layout.php?page=login");
  }

}

// check data format -> return true if correct. Otherwise, return false and set errormessage
function checkParameters($username, $password)
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

function userLoggedCorrectly()
{
  // if the user comes from the link of the article redirect to the page
  if (isset($_SESSION['article-id'])){
    header("Location: ".SessionManager::BASE_URL."article"."&articleId=".$_SESSION['article-id']);
    unset($_SESSION['article-id']);
  }
  else{
	  // redirect to home 
    header("Location: ".SessionManager::BASE_URL."home");
  }
}

?>
