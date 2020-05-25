<?php
class Utils
{
    public static function getMenuLinks($array)
    {
        $list = [];
        for ($x = 0; $x < count($array); $x++) {
            $element = "<a class='menu-item' href='{$array->link}'>{$array->name}</a>";
            array_push($list, $element);
        }
        return implode($list);
    }

    public static function getModelsOptions($array)
    {
        $list = [];
        for ($x = 0; $x < count($array); $x++) {
            $element = "<option value='{$array[$x]}'>{$array[$x]}</option>";
            array_push($list, $element);
        }
        return implode($list);
    }

    public static function isArticleLiked($id)
    {
        $userId = SessionManager::getUserId();
        $votedArticles = Articles::getUserVotes($userId);
        for ($x = 0; $x < count($votedArticles); $x++) {
            if ($votedArticles[$x]->id == $id) {
                if ($votedArticles[$x]->liked) {
                    return 1;
                } else if ($votedArticles[$x]->disliked) {
                    return 0;
                }
            } else {
                return -1;
            }
        }
    }

    public static function replaceContentsArticleItem($html, $item)
    {
        $html = str_replace("{article-model}", $item->model, $html);
        $html = str_replace("{article-link}", "./php/layout.php?page=article&amp;id={$item->id}", $html);
        $html = str_replace("{article-likes}", $item->likes, $html);
        $html = str_replace("{article-dislikes}", $item->dislikes, $html);
        $html = str_replace("{article-img}", $item->imgUrl, $html);
        if (SessionManager::isUserLogged()) {
            switch (Utils::isArticleLiked($item->id)) {
                case 1:
                    $html = str_replace("{article-liked}", 'article-liked', $html);
                    break;
                case 0:
                    $html = str_replace("{article-disliked}", 'article-disliked', $html);
                    break;
                case -1:
                    break;
            }
        }
    }

    public static function replaceContentsAdminArticleItem($html, $item)
    {
        $html = str_replace("{article-model}", $item->model, $html);
        $html = str_replace("{article-link}", "./php/layout.php?page=article&amp;id={$item->id}", $html);
        $html = str_replace("{article-memory}", $item->likes, $html);
        $html = str_replace("{article-price}", $item->dislikes, $html);
        $html = str_replace("{article-img}", $item->imgUrl, $html);
        $html = str_replace("{article-modify}", "./php/layout.php?page=modifyArticle&amp;id={$item->id}", $html);
    }

    public static function getArticles($search, $model, $userId = null)
    {
        return Articles::list($userId, null, $search, $model, null, "ASC");
    }

    public static function generateArticlesList($array)
    {
        $articlesList = [];
        if (!is_array($array)) {
            $array = [];
        }
        for ($x = 0; $x < count($array); $x++) {
            $card = Utils::replaceContentsArticleItem(file_get_contents("../html/article-item.html"), $array[$x]);
            array_push($articlesList, $card);
        }
        return implode($articlesList);
    }

    public static function generateAdminArticlesList($array)
    {
        $articlesList = [];
        if (!is_array($array)) {
            $array = [];
        }
        for ($x = 0; $x < count($array); $x++) {
            $card = Utils::replaceContentsAdminArticleItem(file_get_contents("../html/article-admin-item.html"), $array[$x]);
            array_push($articlesList, $card);
        }
        return implode($articlesList);
    }
}
