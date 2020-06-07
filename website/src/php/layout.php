<?php
include_once("../../server/session_manager.php");
include_once("../../server/db_manager.php");
include_once("../../server/models/models.php");
include_once("../../server/utils.php");

$dbMan = DBManager::getInstance();
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
    public function setHidden($h)
    {
        $this->hidden = $h;
    }
    public function setLink($l)
    {
        $this->link = $l;
    }
    public function setName($n)
    {
        $this->name = $n;
    }
}

$links = [
    new Link("Pagina iniziale", SessionManager::BASE_URL . "home", false),
    new Link("Il mio profilo", SessionManager::BASE_URL . "profile", false),
    new Link("Area Amministratore", SessionManager::BASE_URL . "admin", false),
    new Link("Regolamento", SessionManager::BASE_URL . "rules", false),
    new Link("Domande frequenti", SessionManager::BASE_URL . "faq", false)
];

$userLinks = [
    new Link("Accedi", SessionManager::BASE_URL . "login", false),
    new Link("Registrati", SessionManager::BASE_URL . "registration", false)
];

if (SessionManager::isUserLogged()) {
    $username = SessionManager::getUsername();
    $user = User::getUser(SessionManager::getUserId());
    $links[1]->setHidden(false);
    $links[2]->setHidden(true);
    $userLinks[1]->setName("Disconnettiti");
    $userLinks[1]->setLink(SessionManager::BASE_URL . "home&amp;logout=true");
    $userLinks[0]->setHidden(true);
    if (SessionManager::userCanPublish()) {
        $links[2]->setHidden(false);
    }
} else {
    $links[1]->setHidden(true);
    $links[0]->setHidden(false);
    $links[2]->setHidden(true);
    $userLinks[1]->setName("Registrati");
    $userLinks[1]->setLink(SessionManager::BASE_URL . "registration");
}

if (isset($_GET["logout"])) {
    SessionManager::logout();
    if (isset($_GET['page'])) {
        header("Location: " . SessionManager::BASE_URL . $_GET['page']);
    } else {
        header("Location: " . SessionManager::BASE_URL . "home");
    }
}

function noPermissions()
{
    if (!SessionManager::isUserLogged() || (SessionManager::isUserLogged() && !SessionManager::userCanPublish())) {
        header("Location: " . SessionManager::BASE_URL . "no-permissions");
    }
}

switch ($_GET['page']) {
    case 'login':
        $breadcrumb = "<li>&#62;&#62; <a>Accedi</a></li>";
        $page = file_get_contents("../html/login.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Telefolandia - Accedi", $output);
        $linkItems = Utils::getMenuLinks($links, null);
        $userItems = Utils::getMenuLinks($userLinks, 'Accedi');
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{user-links}", $userItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-user-links}", $userItems, $output);
        include_once("../php/login.php");
        break;

    case 'registration':
        $breadcrumb = "<li>&#62;&#62; <a>Registrati</a></li>";
        $page = file_get_contents("../html/registration.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Telefolandia - Registrati", $output);
        $linkItems = Utils::getMenuLinks($links, null);
        $userItems = Utils::getMenuLinks($userLinks, 'Registrati');
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{user-links}", $userItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-user-links}", $userItems, $output);
        include_once("../php/registration.php");
        break;

    case 'home':
        $breadcrumb = "<li>&#62;&#62; <a>Pagina iniziale</a></li>";
        $page = file_get_contents("../html/home.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Telefolandia - Pagina iniziale", $output);
        $linkItems = Utils::getMenuLinks($links, "Pagina iniziale");
        $userItems = Utils::getMenuLinks($userLinks, null);
        $output = str_replace("{user-links}", $userItems, $output);
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-user-links}", $userItems, $output);
        include_once("../php/home.php");
        break;

    case 'profile':
        $breadcrumb = "<li>&#62;&#62; <a href=\"" . SessionManager::BASE_URL . 'home' . "\">Pagina iniziale</a></li><li>&#62;&#62;<a>Il mio profilo</a></li>";
        $page = file_get_contents("../html/profile.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Telefolandia - Il mio profilo", $output);
        $linkItems = Utils::getMenuLinks($links, "Il mio profilo");
        $userItems = Utils::getMenuLinks($userLinks, null);
        $output = str_replace("{user-links}", $userItems, $output);
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-user-links}", $userItems, $output);
        include_once("../php/profile.php");
        break;

    case 'article':
        $article = null;
        if (isset($_GET['articleId'])) {
            $id = $_GET['articleId'];
            $article = Utils::getArticleFromId($id);
        }
        $breadcrumb = "<li>&#62;&#62; <a href=\"" . SessionManager::BASE_URL . 'home' . "\">Pagina iniziale</a></li><li>&#62;&#62; <span>Articolo - {$article->model} </span></li>";
        $page = file_get_contents("../html/article-page.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $linkItems = Utils::getMenuLinks($links, null);
        $userItems = Utils::getMenuLinks($userLinks, null);
        $output = str_replace("{user-links}", $userItems, $output);
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        $output = str_replace("{currentPage}", "Telefolandia - Articolo {$article->model}", $output);
        $output = str_replace("{mobile-user-links}", $userItems, $output);
        include_once("../php/article_page.php");
        break;

    case 'rules':
        $breadcrumb = "<li>&#62;&#62; <a href=\"" . SessionManager::BASE_URL . 'home' . "\">Pagina iniziale</a></li><li>&#62;&#62; <span>Regolamento</span></li>";
        $page = file_get_contents("../html/rules.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Telefolandia - Regolamento", $output);
        $linkItems = Utils::getMenuLinks($links, "Regolamento");
        $userItems = Utils::getMenuLinks($userLinks, null);
        $output = str_replace("{user-links}", $userItems, $output);
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-user-links}", $userItems, $output);
        break;

    case 'faq':
        $breadcrumb = "<li>&#62;&#62; <a href=\"" . SessionManager::BASE_URL . 'home' . "\">Pagina iniziale</a></li><li>&#62;&#62; <span>Domande frequenti</span></li>";
        $page = file_get_contents("../html/faq.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Telefolandia - Domande frequenti", $output);
        $linkItems = Utils::getMenuLinks($links, "Domande frequenti");
        $userItems = Utils::getMenuLinks($userLinks, null);
        $output = str_replace("{user-links}", $userItems, $output);
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-user-links}", $userItems, $output);
        include_once("../php/faq_page.php");
        break;

    case 'admin':
        noPermissions();
        $breadcrumb = "<li>&#62;&#62; <a href=\"" . SessionManager::BASE_URL . 'home' . "\">Pagina iniziale</a></li><li>&#62;&#62; <span>Area Amministratore</span></li>";
        $page = file_get_contents("../html/admin.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Telefolandia - Area Amministratore", $output);
        $linkItems = Utils::getMenuLinks($links, "Area Amministratore");
        $userItems = Utils::getMenuLinks($userLinks, null);
        $output = str_replace("{user-links}", $userItems, $output);
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-user-links}", $userItems, $output);
        include_once("../php/admin.php");
        break;
    case 'add-article':
        noPermissions();
        $breadcrumb = "<li>&#62;&#62; <a href=\"" . SessionManager::BASE_URL . 'home' . "\">Pagina iniziale</a></li><li>&#62;&#62; <a href=\"" . SessionManager::BASE_URL . 'admin' . "\">Area Amministratore</a></li><li>&#62;&#62; <span>Aggiungi articolo</span></li>";
        $page = file_get_contents("../html/admin-form.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Telefolandia - Aggiungi articolo", $output);
        $linkItems = Utils::getMenuLinks($links, null);
        $userItems = Utils::getMenuLinks($userLinks, null);
        $output = str_replace("{user-links}", $userItems, $output);
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-user-links}", $userItems, $output);
        include_once("../php/admin_add_article.php");
        break;
    case 'modify-article':
        noPermissions();
        $breadcrumb = "<li>&#62;&#62; <a href=\"" . SessionManager::BASE_URL . 'home' . "\">Pagina iniziale</a></li><li>&#62;&#62; <a href=\"" . SessionManager::BASE_URL . 'admin' . "\">Area Amministratore</a></li><li>&#62;&#62; <span>Modifica articolo</span></li>";
        $page = file_get_contents("../html/admin-form.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Telefolandia - Modifica articolo", $output);
        $linkItems = Utils::getMenuLinks($links, null);
        $userItems = Utils::getMenuLinks($userLinks, null);
        $output = str_replace("{user-links}", $userItems, $output);
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-user-links}", $userItems, $output);
        include_once("../php/admin_modify_article.php");
        break;
    case 'no-permissions':
        $breadcrumb = "<li>&#62;&#62; <a href=\"" . SessionManager::BASE_URL . 'home' . "\">Pagina iniziale</a></li><li>&#62;&#62; <span>Zona Amministratore</span></li>";
        $page = file_get_contents("../html/no-permissions.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Telefolandia - Non hai i permessi", $output);
        $linkItems = Utils::getMenuLinks($links, null);
        $userItems = Utils::getMenuLinks($userLinks, null);
        $output = str_replace("{user-links}", $userItems, $output);
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-user-links}", $userItems, $output);
        break;
    default:
        $breadcrumb = "<li>&#62;&#62; <a href=\"" . SessionManager::BASE_URL . 'home' . "\">Pagina iniziale</a></li><li>&#62;&#62; <span>404</span></li>";
        $page = file_get_contents("../html/404.html");
        $output = str_replace("{breadcrumb}", $breadcrumb, $output);
        $output = str_replace("{content}", $page, $output);
        $output = str_replace("{currentPage}", "Telefolandia - 404", $output);
        $linkItems = Utils::getMenuLinks($links, null);
        $userItems = Utils::getMenuLinks($userLinks, null);
        $output = str_replace("{user-links}", $userItems, $output);
        $output = str_replace("{menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-menu-links}", $linkItems, $output);
        $output = str_replace("{mobile-user-links}", $userItems, $output);
        break;
}

echo $output;
