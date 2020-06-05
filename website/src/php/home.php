<?php

$modelsList = Utils::getModelsOptions(Article::getModelsList());

$output = str_replace("<option>{modelOptions}</option>", $modelsList, $output);
$model = null;
$ordine = null;
$search = null;

if (isset($_GET['model'])) {
    if ($_GET['model'] != 'all') {
        $model = $_GET['model'];
    }
}

if (isset($_GET['ordine'])) {
    if ($_GET['ordine'] != 'all') {
        $ordine = $_GET['ordine'];
    }
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$list = Utils::getArticles($search, $model, $ordine);
$articlesList = Utils::generateArticlesList($list);
if ($articlesList != '') {
    $output = str_replace("{articles}", $articlesList, $output);
} else {
    $output = str_replace("{articles}", "Nessun articolo trovato.", $output);
}
?>