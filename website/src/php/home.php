<?php

$modelsList = Utils::getModelsOptions(Article::getModelsList());

$output = str_replace("<option>{modelOptions}</option>", $modelsList, $output);
$model = null;
$price = null;
$search = null;

if (isset($_GET['model'])) {
    if ($_GET['model'] != 'all') {
        $model = $_GET['model'];
    }
}

if (isset($_GET['price'])) {
    if ($_GET['price'] != 'all') {
        $model = $_GET['price'];
    }
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$userId = null;
if (SessionManager::isUserLogged()) {
    $userId = SessionManager::getUserId();
}

$list = Utils::getArticles($search, $model, $price, $userId);
$articlesList = Utils::generateArticlesList($list);
if ($articlesList != '') {
    $output = str_replace("{articles}", $articlesList, $output);
} else {
    $output = str_replace("{articles}", "Nessun articolo trovato.", $output);
}
?>