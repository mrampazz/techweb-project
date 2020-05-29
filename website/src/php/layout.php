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
    
    public function setLink($l) {
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

if (SessionManager::isUserLogged()) {
    $username = SessionManager::getUsername();
    $user = User::getUser(SessionManager::getUserId());
    $output = str_replace("{loginLink}", "../php/layout.php?page=profile", $output);
    $output = str_replace("{registrationLink}", "../php/layout.php?page=login&logout=true", $output);
    $output = str_replace("{LOGIN}", "PROFILO", $output);
    $output = str_replace("{REGISTRAZIONE}", "LOGOUT", $output);
    $links[1]->setLink(SessionManager::BASE_URL . "profile");
    $links[2]->setLink(SessionManager::BASE_URL . "profile&likes=true");
    if (SessionManager::userCanPublish()) {
        array_push($links, new Link("Amministratore", SessionManager::BASE_URL . "admin" ));
    }
} else {
    $output = str_replace("{loginLink}", "../php/layout.php?page=login", $output);
    $output = str_replace("{registrationLink}", "../php/layout.php?page=registration", $output);
    $output = str_replace("{LOGIN}", "LOGIN", $output);
    $output = str_replace("{REGISTRAZIONE}", "REGISTRAZIONE", $output);
    $links[1]->setLink("../php/layout.php?page=login");
    $links[2]->setLink("../php/layout.php?page=login");
}

if (isset($_GET["logout"])) {
    SessionManager::logout();
    header("Location: " . SessionManager::BASE_URL . "home");
}

switch ($_GET['page']) {
    case 'login':
        $breadcrumb = "<li>&#62;&#62; <a>Login</a></li>";
        $page = file_get_contents("../html/login.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Login", $output);
        $output = str_replace("{menu-links}", Utils::getMenuLinks($links, null), $output);
        include_once("../php/login.php");
        break;

    case 'registration':
        $breadcrumb = "<li>&#62;&#62; <a>Registrazione</a></li>";
        $page = file_get_contents("../html/registration.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Registrazione", $output);
        $output = str_replace("{menu-links}", Utils::getMenuLinks($links, null), $output);
        include_once("../php/registration.php");
        break;
        
    case 'home':
        $breadcrumb = "<li>&#62;&#62; <a>Home</a></li>";
        $page = file_get_contents("../html/home.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Homepage", $output);
        $output = str_replace("{menu-links}", Utils::getMenuLinks($links, "Home"), $output);
        include_once("../php/home.php");
        break;

    case 'profile':
        $breadcrumb = "<li>&#62;&#62; <a href='" . SessionManager::BASE_URL . 'home' . "'>Home</a></li><li>&#62;&#62;<a>Profilo</a></li>";
        $page = file_get_contents("../html/profile.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Il tuo profilo", $output);
        $output = str_replace("{menu-links}", Utils::getMenuLinks($links, "Il tuo profilo"), $output);
        include_once("../php/profile.php");
        break;

    case 'article':
        $article = null;
        if (isset($_GET['articleId'])) {
            $id = $_GET['articleId'];
            $article = Utils::getArticleFromId($id);
        }
        $breadcrumb = "<li>&#62;&#62; <a href='" . SessionManager::BASE_URL . 'home' . "'>Home</a></li><li>&#62;&#62; <span>Articolo - {$article->model} </span></li>";
        $page = file_get_contents("../html/article-page.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Articolo {$article->model}", $output);
        $output = str_replace("{menu-links}", Utils::getMenuLinks($links, null), $output);
        include_once("../php/article_page.php");
        break;

    case 'rules':
        $breadcrumb = "<li>&#62;&#62; <a href='" . SessionManager::BASE_URL . 'home' . "'>Home</a></li><li>&#62;&#62; <span>Regolamento</span></li>";
        $page = file_get_contents("../html/rules.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Regolamento", $output);
        $output = str_replace("{menu-links}", Utils::getMenuLinks($links, "Regolamento"), $output);
        // include_once("../php/rules.php");
        break;

    case 'about':
        $breadcrumb = "<li>&#62;&#62; <a href='" . SessionManager::BASE_URL . 'home' . "'>Home</a></li><li>&#62;&#62; <span>Chi siamo?</span></li>";
        $page = file_get_contents("../html/about.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Chi siamo?", $output);
        $output = str_replace("{menu-links}", Utils::getMenuLinks($links, "Chi siamo?"), $output);
        // include_once("../php/about.php");
        break;

    case 'faq':
        $breadcrumb = "<li>&#62;&#62; <a href='" . SessionManager::BASE_URL . 'home' . "'>Home</a></li><li>&#62;&#62; <span>FAQ</span></li>";
        $page = file_get_contents("../html/faq.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "FAQ", $output);
        $output = str_replace("{menu-links}", Utils::getMenuLinks($links, "FAQ"), $output);
        include_once("../php/faq_page.php");
        break;
}

echo $output;
?>