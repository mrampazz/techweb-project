<?php
$article = null;
$id = null;
if (isset($_GET['id'])) {
    if ($_GET['id']) {
        $id = $_GET['id'];
    }
}
$article = Utils::getArticleFromId($id);
if ($article) {
    $output = str_replace('{edit}', 'Modifica', $output);
    $output = str_replace('{brand}', $article->brand, $output);
    $output = str_replace('{model}', $article->model, $output);
    $output = str_replace('{price}', $article->initialPrice, $output);
    $output = str_replace('{amzn-link}', $article->link, $output);
    $output = str_replace('{desc}', $article->content, $output);
    $output = str_replace('{date}', date("d-m-Y", strtotime($article->launchDate)), $output);
    $output = str_replace('article-image-url', '../assets/img/articles/'.$article->image, $output);
}
?>
