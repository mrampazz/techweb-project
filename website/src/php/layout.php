<?php
include_once ("../../server/db_manager.php");
include_once ("../../server/session_manager.php");
include_once ("../../server/models/models.php");
include_once ("../../server/utils.php");

$output = file_get_contents("../html/layout.html");

class Link {
    constructor($n, $l) {
        $name = $n;
        $link = $l;
    }
    public $name;
    public $link;
}

$links = [
    new Link("Home", SessionManager::BASE_URL."home"),
    new Link("Il tuo profilo", SessionManager::BASE_URL."profile"),
    new Link("I tuoi voti", SessionManager::BASE_URL."profile&likes=true"),
    new Link("Regolamento", SessionManager::BASE_URL."rules"),
    new Link("Chi siamo?", SessionManager::BASE_URL."about"),
    new Link("FAQ", SessionManager::BASE_URL."faq"),
];

$output = str_replace("{menuLinks}", Utils::getMenuLinks($links), $output);

if (SessionManager::isUserLogged())
{
    $username = SessionManager::getUsername();
    $user = User::getUser(SessionManager::getUserId());
    $output = str_replace("{loginLink}", "./php/login.php?page=profilo", $output);
    $output = str_replace("{registrationLink}", "./php/login.php?logout=true", $output);
    $output = str_replace("{LOGIN}", "PROFILO", $output);
    $output = str_replace("{REGISTRAZIONE}", "LOGOUT", $output);

} else {
    $output = str_replace("{loginLink}", "./php/login.php", $output);
    $output = str_replace("{registrationLink}", "./php/login.php", $output);
    $output = str_replace("{LOGIN}", "LOGIN", $output);
    $output = str_replace("{REGISTRAZIONE}", "REGISTRAZIONE", $output);
}

if (isset($_GET["logout"])) {
    SessionManager::logout();
    header("Location: ".SessionManager::BASE_URL."home");
}

switch ($_GET['page'])
{
    case 'home':
        $page = file_get_contents("../html/home.html");
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Homepage", $output);
        include_once ("./home.php");
    break;

    case 'profile':
        $page = file_get_contents("../html/profilo.html");
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Il tuo profilo", $output);
        include_once ("./profile.php");
    break;

    case 'rules':
        $page = file_get_contents("../html/rules.html");
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Regolamento", $output);
        include_once ("./rules.php");
    break;

    case 'about':
        $page = file_get_contents("../html/about.html");
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Chi siamo?", $output);
        include_once ("./about.php");
    break;

    case 'faq':
        $page = file_get_contents("../html/faq.html");
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "FAQ", $output);
        include_once ("./faq.php");
    break;
}

echo $output;
?>