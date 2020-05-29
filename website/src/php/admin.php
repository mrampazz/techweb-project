<?php
$list = Utils::getArticles(null, null, null);
$articlesList = Utils::generateAdminArticlesList($list);

if ($articlesList != '') {
    $output = str_replace("{articles}", $articlesList, $output);
} else {
    $output = str_replace("{articles}", "Nessun articolo trovato.", $output);
}
?>