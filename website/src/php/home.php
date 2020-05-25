<?php
$modelsList = Utils::getModelsOptions(ArticleModels::getModelsList());

$output = str_replace("<option>{modelOptions}</option>", $modelsList, $output);

$model = null;
$search = null;

if (isset($_GET['model'])) {
    if ($_GET['model'] != 'all') {
        $model = $_GET['model'];
    }
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}


$userId = null;
if (SessionManager::isUserLogged()) {
    $userId = SessionManager::getUserId();
}

$list = Utils::getArticles($search, $model, $userId);
$articlesList = Utils::generateArticlesList($list);

if ($articlesList != '') {
    $output = str_replace("{articles}", $articlesList, $output);
} else {
    $output = str_replace("{articles}", "Nessun articolo trovato.", $output);
}
?>