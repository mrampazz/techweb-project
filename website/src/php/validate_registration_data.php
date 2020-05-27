<?php
include_once("../../../database/session_manager.php");
include_once("../../../database/db_manager.php");
include_once("../../server/utils.php");
include_once("../../server/models/models.php");

// define variables and set to empty values
$_SESSION['registration'] = false; //not registered by default
$_SESSION['error-message'] = "";
$username = "";
$name = "";
$surname = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
  $username = Utils::validateInput($_POST["username"]);
  $password = Utils::validateInput($_POST["password"]);
  $confirmationPassword = Utils::validateInput($_POST["confirmationPassword"]);
  $name = Utils::validateInput($_POST["name"]);
  $surname = Utils::validateInput($_POST["surname"]);
  $email = Utils::validateInput($_POST["email"]);
  $_SESSION['username'] = $username;
  $_SESSION['name'] = $name;
  $_SESSION['surname'] = $surname;
  $_SESSION['email'] = $email;
   
    
  if (checkParameters($username, $password, $confirmationPassword, $name, $surname, $email, $errorMessage)) // if true parameters are in the correct format -> try to register
  {
    $man = DBManager::getInstance();
    $reg = $man->register($username, $password, $name, $surname, $email);
    if ($reg!=false) //if registered correctly
    {
      $_SESSION['registration'] = true;
      SessionManager::startSessionForUser($reg, $username, false);
      userRegisteredCorrectly();
    } else {
      $_SESSION['error-message'] = "la registrazione non ha avuto successo.";
    }
  }
  else{
    header("Location: ../php/registration.php");
  }

}

// check data format -> return true if correct. Otherwise, return false and set errormessage
function checkParameters($username, $password, $confirmationPassword, $name, $surname, $email, &$errorMessage)
{
	if (empty($username)) {
	  $_SESSION['error-message'] .= " l'username è richiesto! ";
		return false;
  }
  else if(!preg_match("/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/",$username)){
    $_SESSION['error-message'] .= " controlla l'username! Il campo non può essere composto da caratteri speciali. ";
		return false;
  } 
  if (empty($name)) {
		$_SESSION['error-message'] .= " il nome è richiesto! ";
		return false;
  }
  else if(!preg_match("/^[a-zA-Z ]{1,16}$/",$name)){
    $_SESSION['error-message'] .= " controlla il Nome! Il campo dev'essere composto solamente da lettere. ";
		return false;
  }
  if (empty($surname)) {
		$_SESSION['error-message'] .= " il cognome è richiesto! ";
		return false;
  } 
  else if(!preg_match("/^[a-zA-Z ]{1,16}$/",$surname)){
    $_SESSION['error-message'] .= " controlla il Cognome! Il campo dev'essere composto solamente da lettere. ";
		return false;
  }
	if (empty($email)) {
		$_SESSION['error-message'] .= " l'email è richiesta! ";
		return false;
  }
  else if(!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/",$email)){
    $_SESSION['error-message'] .= " controlla l'email! Il campo non rispetta la sintassi corretta. ";
		return false;
  }
	if (empty($password)) {
		$_SESSION['error-message'] .= " la password è richiesta! ";
		return false;
  }
  else if(!preg_match("/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9!.@#$%^&*]{6,32}$/",$password)){
    $_SESSION['error-message'] .= " controlla la password! Dev'essere alfanumerica ed essere composta da almeno 6 caratteri. ";
    return false;
  }

  if (empty($confirmationPassword)) {
		$_SESSION['error-message'] .= " la password di conferma è richiesta! ";
    return false;
  }
  else if($confirmationPassword!=$password){
		$_SESSION['error-message'] .= " la password di conferma è diversa dalla password! ";
		return false;
	} 

	return true;
}

function RegUser($username, $password, $confirmationPassword, $name, $surname, $email)
{		
	// ask db manager to create a new account
	return false;
}

function userRegisteredCorrectly()
{
  // redirect to home and save session data
  header("Location: ".SessionManager::BASE_URL."home");
}

?>


