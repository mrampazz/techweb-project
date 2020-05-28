<?php
include_once("../../../database/session_manager.php");
include_once("../../../database/db_manager.php");
include_once("../../server/models/models.php");
include_once("../../server/utils.php");

$output = file_get_contents("../html/layout.html");

class Link
{
    public $name;
    public $link;
    public function __construct($n, $l)
    {
        $this->name = $n;
        $this->link = $l;
    }
}

$links = [
    new Link("Home", SessionManager::BASE_URL . "home"),
    new Link("Il tuo profilo", SessionManager::BASE_URL . "profile"),
    new Link("I tuoi voti", SessionManager::BASE_URL . "profile&likes=true"),
    new Link("Regolamento", SessionManager::BASE_URL . "rules"),
    new Link("Chi siamo?", SessionManager::BASE_URL . "about"),
    new Link("FAQ", SessionManager::BASE_URL . "faq"),
];

$output = str_replace("{menuLinks}", Utils::getMenuLinks($links), $output);


if (SessionManager::isUserLogged()) {
    $username = SessionManager::getUsername();
    $user = User::getUser(SessionManager::getUserId());
    $output = str_replace("{loginLink}", "../php/login.php?page=profile", $output);
    $output = str_replace("{registrationLink}", "../php/login.php?logout=true", $output);
    $output = str_replace("{LOGIN}", "PROFILO", $output);
    $output = str_replace("{REGISTRAZIONE}", "LOGOUT", $output);
} else {
    $output = str_replace("{loginLink}", "../php/login.php", $output);
    $output = str_replace("{registrationLink}", "../php/registration.php", $output);
    $output = str_replace("{LOGIN}", "LOGIN", $output);
    $output = str_replace("{REGISTRAZIONE}", "REGISTRAZIONE", $output);
}

if (isset($_GET["logout"])) {
    SessionManager::logout();
    header("Location: " . SessionManager::BASE_URL . "home");
}

switch ($_GET['page']) {
    case 'home':
        $breadcrumb = "<li>&#62;&#62; <a>Home</a></li>";
        $page = file_get_contents("../html/home.html");
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Homepage", $output);
        include_once("../php/home.php");
        break;

    case 'profile':
        $breadcrumb = "<li>&#62;&#62; href='" . SessionManager::BASE_URL . 'home' . "'<a>Home</a></li><li>&#62;&#62;<a>Profilo</a></li>";
        $page = file_get_contents("../html/profile.html");
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Il tuo profilo", $output);
        include_once("../php/profile.php");
        break;

    case 'article':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $article = Articles::getArticleFrom($id);
        }
        $breadcrumb = "<li>&#62;&#62; href='" . SessionManager::BASE_URL . 'home' . "'<a>Home</a></li><li>&#62;&#62;<a>Articolo {$article->name} </a></li>";
        $page = file_get_contents("../html/article-page.html");
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Articolo {$article->name}", $output);
        include_once("../php/article_page.php");
        break;

    case 'rules':
        $breadcrumb = "<li>&#62;&#62; href='" . SessionManager::BASE_URL . 'home' . "'<a>Home</a></li><li>&#62;&#62;<a>Regolamento</a></li>";
        $page = file_get_contents("../html/rules.html");
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Regolamento", $output);
        include_once("../php/rules.php");
        break;

    case 'about':
        $breadcrumb = "<li>&#62;&#62; href='" . SessionManager::BASE_URL . 'home' . "'<a>Home</a></li><li>&#62;&#62;<a>Chi siamo?</a></li>";
        $page = file_get_contents("../html/about.html");
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Chi siamo?", $output);
        include_once("../php/about.php");
        break;

    case 'faq':
        $breadcrumb = "<li>&#62;&#62; href='" . SessionManager::BASE_URL . 'home' . "'<a>Home</a></li><li>&#62;&#62;<a>FAQ</a></li>";
        $page = file_get_contents("../html/faq.html");
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "FAQ", $output);
        include_once("../php/faq.php");
        break;
}

echo $output;
?>