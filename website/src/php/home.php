<?php


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


$modelsList = Utils::getModelsOptions(Article::getModelsList(), $model);
$orderList = Utils::getPriceSelectOptions($ordine);

$output = str_replace("<option>{modelOptions}</option>", $modelsList, $output);
$output = str_replace("<option>{orderOptions}</option>", $orderList, $output);

if (isset($_GET['search'])) {
    $search = Utils::validateInput($_GET['search']);
}
$output = str_replace("{search-preset}", $search, $output);

$list = Utils::getArticles($search, $model, $ordine);
$articlesList = Utils::generateArticlesList($list);
if ($articlesList != '') {
    $output = str_replace("{articles}", $articlesList, $output);
} else {
    $output = str_replace("{articles}", "Nessun articolo trovato.", $output);
}
?>