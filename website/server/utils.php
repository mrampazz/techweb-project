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

    public static function replaceContentsMovieCard($card, $title, $coverUrl, $stars, $id, $votesTotal, $votesPositive, $isFav)
    {
        $starNumber = [];
        if ($votesPositive == null) {
            $card = str_replace("{likes}", 0, $card);
        } else {
            $card = str_replace("{likes}", $votesPositive, $card);
        }
        $movie = Media::fetch($id);
        if ($movie->hasEpisodes == 1) {
            $card = str_replace("{isMovie}", "Serie", $card);
        } else {
            $card = str_replace("{isMovie}", "Film", $card);
        }
        $card = str_replace("{movieTitle}", $title, $card);
        $card = str_replace("{mediaNotFav}", !($isFav == true) ? "" : "hidden", $card);
        $card = str_replace("{mediaIsFav}", ($isFav == true) ? "" : "hidden", $card);
        $card = str_replace("{dislikes}", $votesTotal - $votesPositive, $card);
        $card = str_replace("coverURL", "../public/" . $coverUrl, $card);
        $card = str_replace("{movieID}", $id, $card);
        $card = str_replace("linkDettaglioMovie", "./php/layout.php?page=dettaglio&amp;movieId=" . $id, $card);
        $check = Utils::checkLikedMovies($id);
        switch ($check) {
            case 1:
                $card = str_replace("{like-selected}", "thumb-selected", $card);
                break;
            case 0:
                $card = str_replace("{dislike-selected}", "thumb-selected", $card);
                break;
            case -1: {
                    $card = str_replace("{like-selected}", " ", $card);
                    $card = str_replace("{dislike-selected}", " ", $card);
                }
                break;
        }
        for ($i = 0; $i < $stars; $i++) {
            array_push($starNumber, "<i class='fa fa-star'></i>");
        }
        $card = str_replace("{starNumber}", $stars, $card);
        $card = str_replace("{movieStars}", implode($starNumber), $card);
        return $card;
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

    public static function replaceContentsArticleItem($html, $id, $title, $imgUrl, $likes, $dislikes)
    {
        $html = str_replace("{article-title}", $title, $html);
        $html = str_replace("{article-link}", "./php/layout.php?page=article&amp;id={$id}", $html);
        $html = str_replace("{article-likes}", $likes, $html);
        $html = str_replace("{article-dislikes}", $dislikes, $html);
        $html = str_replace("{article-img}", $imgUrl, $html);
        if (SessionManager::isUserLogged()) {
            switch (Utils::isArticleLiked($id)) {
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
            $card = Utils::replaceContentsArticleItem(file_get_contents("../html/article-item.html"), $array->id, $array->title, $array->imgUrl, $array->likes, $array->dislikes);
            array_push($articlesList, $card);
        }
        return implode($articlesList);
    }
}
