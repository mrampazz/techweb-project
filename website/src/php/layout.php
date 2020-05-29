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
    public $hidden;
    public function __construct($n, $l, $h)
    {
        $this->name = $n;
        $this->link = $l;
        $this->hidden = $h;
    }
    public function setHidden($h) {
        $this->hidden = $h;
    }
    public function setLink($l) {
        $this->link = $l;
    }
    public function setName($n) {
        $this->name = $n;
    }
}

$links = [
    new Link("Home", SessionManager::BASE_URL . "home", false),
    new Link("Il tuo profilo", SessionManager::BASE_URL . "profile", false),
    new Link("Regolamento", SessionManager::BASE_URL . "rules", false),
    new Link("Chi siamo?", SessionManager::BASE_URL . "about", false),
    new Link("Zona amministratori", SessionManager::BASE_URL . "admin", false),
    new Link("Login", SessionManager::BASE_URL . "login", false),
    new Link("Registrati", SessionManager::BASE_URL . "registration", false),
    new Link("FAQ", SessionManager::BASE_URL . "faq", false)
];

if (SessionManager::isUserLogged()) {
    $username = SessionManager::getUsername();
    $user = User::getUser(SessionManager::getUserId());
    $links[1]->setHidden(false);
    $links[4]->setHidden(true);
    $links[5]->setHidden(true);
    $links[6]->setName("Log out");
    $links[6]->setLink(SessionManager::BASE_URL . "home&amp;logout=true");

    if (SessionManager::userCanPublish()) {
        $links[4]->setHidden(false);
    }
} else {
    $links[1]->setHidden(true);
    $links[5]->setHidden(false);
    $links[4]->setHidden(true);
    $links[6]->setName("Registrati");
    $links[6]->setLink(SessionManager::BASE_URL . "registration");
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
        $linkItems = Utils::getMenuLinks($links, 'Login');
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        include_once("../php/login.php");
        break;

    case 'registration':
        $breadcrumb = "<li>&#62;&#62; <a>Registrazione</a></li>";
        $page = file_get_contents("../html/registration.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Registrazione", $output);
        $linkItems = Utils::getMenuLinks($links, 'Registrati');
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        include_once("../php/registration.php");
        break;
        
    case 'home':
        $breadcrumb = "<li>&#62;&#62; <a>Home</a></li>";
        $page = file_get_contents("../html/home.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Homepage", $output);
        $linkItems = Utils::getMenuLinks($links, 'Home');
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        include_once("../php/home.php");
        break;

    case 'profile':
        $breadcrumb = "<li>&#62;&#62; <a href='" . SessionManager::BASE_URL . 'home' . "'>Home</a></li><li>&#62;&#62;<a>Profilo</a></li>";
        $page = file_get_contents("../html/profile.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Il tuo profilo", $output);
        $linkItems = Utils::getMenuLinks($links, 'Il tuo profilo');
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
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
        $output = str_replace("{menu-links}", $linkItems, $output);
        $linkItems = Utils::getMenuLinks($links, null);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        $output = str_replace("{currentPage}", "Articolo {$article->model}", $output);
        include_once("../php/article_page.php");
        break;

    case 'rules':
        $breadcrumb = "<li>&#62;&#62; <a href='" . SessionManager::BASE_URL . 'home' . "'>Home</a></li><li>&#62;&#62; <span>Regolamento</span></li>";
        $page = file_get_contents("../html/rules.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Regolamento", $output);
        $linkItems = Utils::getMenuLinks($links, 'Regolamento');
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        // include_once("../php/rules.php");
        break;

    case 'about':
        $breadcrumb = "<li>&#62;&#62; <a href='" . SessionManager::BASE_URL . 'home' . "'>Home</a></li><li>&#62;&#62; <span>Chi siamo?</span></li>";
        $page = file_get_contents("../html/about.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Chi siamo?", $output);
        $linkItems = Utils::getMenuLinks($links, 'Chi siamo?');
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        // include_once("../php/about.php");
        break;

    case 'faq':
        $breadcrumb = "<li>&#62;&#62; <a href='" . SessionManager::BASE_URL . 'home' . "'>Home</a></li><li>&#62;&#62; <span>FAQ</span></li>";
        $page = file_get_contents("../html/faq.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "FAQ", $output);
        $linkItems = Utils::getMenuLinks($links, 'FAQ');
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        include_once("../php/faq_page.php");
        break;
}

echo $output;
?>