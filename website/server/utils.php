<?php
class Utils
{

    public static function getMenuLinks($array, $name)
    {
        $list = [];
        for ($x = 0; $x < count($array); $x++) {
            if ($name && $array[$x]->name == $name) {
                $element = "<span class='menu-item-active'>{$array[$x]->name}</span>";
            } else {
                if ($array[$x]->hidden) {
                    $element = "<a class='menu-item hidden' href='{$array[$x]->link}'>{$array[$x]->name}</a>";
                } else {
                    $element = "<a class='menu-item' href='{$array[$x]->link}'>{$array[$x]->name}</a>";
                }
            }

            array_push($list, $element);
        }
        return implode($list);
    }

    public static function getMobileMenuLinks($array, $name)
    {
        $list = [];
        for ($x = 0; $x < count($array); $x++) {
            if ($name && $array[$x]->name == $name) {
                $element = "<span class='menu-item-active'>{$array[$x]->name}</span>";
            } else {
                $element = "<a class='menu-item' href='{$array[$x]->link}'>{$array[$x]->name}</a>";
            }

            array_push($list, $element);
        }
        return implode($list);
    }

    public static function getModelsOptions($array)
    {
        $list = [];
        for ($x = 0; $x < count($array); $x++) {
            $element = "<option value='{$array[$x]->brand}'>{$array[$x]->brand}</option>";
            array_push($list, $element);
        }
        return implode($list);
    }

    public static function isArticleLiked($id)
    {
        $votedArticles = null;
        if (SessionManager::isUserLogged()) {
            $userId = SessionManager::getUserId();
            $votedArticles = Article::getUserVotes($userId);
        }
        if ($votedArticles != null) {
            for ($x = 0; $x < count($votedArticles); $x++) {
                if ($votedArticles[$x]->article_id == $id) {
                    switch ($votedArticles[$x]->positive) {
                        case 1:
                            return 1;
                            break;
                        case 0:
                            return 0;
                            break;
                    }
                }
            }
            return -1;
        } else {
            return -1;
        }
    }

    public static function replaceContentsArticleItem($html, $item)
    {
        $html = str_replace("{articleID}", $item->id, $html);
        $html = str_replace("{article-model}", $item->model, $html);
        $html = str_replace("{article-brand}", $item->brand, $html);
        $html = str_replace("{article-link}", "./layout.php?page=article&amp;articleId={$item->id}", $html);
        $html = str_replace("{article-likes}", $item->votesPositive ? $item->votesPositive : "0", $html);
        $html = str_replace("{article-dislikes}", ($item->votesTotal) - ($item->votesPositive), $html);
        $html = str_replace("{article-img}", "../assets/img/articles/" . $item->image, $html);
        if (SessionManager::isUserLogged()) {
            switch (Utils::isArticleLiked($item->id)) {
                case 1:
                    $html = str_replace("{article-liked}", 'thumb-selected', $html);
                    break;
                case 0:
                    $html = str_replace("{article-disliked}", 'thumb-selected', $html);
                    break;
                case -1:
                    break;
            }
        }
        return $html;
    }

    public static function replaceContentsAdminArticleItem($html, $item)
    {
        $html = str_replace("{article-model}", $item->model, $html);
        $html = str_replace("{article-link}", "./layout.php?page=article&amp;id={$item->id}", $html);
        $html = str_replace("{modify-article}", "./layout.php?page=modify-article&amp;edit=true&amp;id={$item->id}", $html);
        $html = str_replace("{article-memory}", $item->votesPositive, $html);
        $html = str_replace("{article-price}", ($item->votesTotal) - ($item->votesPositive), $html);
        $html = str_replace("{article-img}", "../assets/img/articles/" . $item->image, $html);
        $html = str_replace("{article-modify}", "./layout.php?page=modifyArticle&amp;id={$item->id}", $html);
        return $html;
    }

    public static function replaceContentsFaqItem($html, $item)
    {
        $html = str_replace("{question}", $item->title, $html);
        $html = str_replace("{answer}", $item->content, $html);
        return $html;
    }


    public static function getArticles($search, $model, $price, $userId = null)
    {
        // return Article::list($userId, null, $search, $model, null, "ASC");
        return Article::list();
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

    public static function generateFaqList($array)
    {
        $faqList = [];
        if (!is_array($array)) {
            $array = [];
        }
        for ($x = 0; $x < count($array); $x++) {
            $item = Utils::replaceContentsFaqItem(file_get_contents("../html/faq-item.html"), $array[$x]);
            array_push($faqList, $item);
        }
        return implode($faqList);
    }

    public static function generateAdminArticlesList($array)
    {
        $articlesList = [];
        if (!is_array($array)) {
            $array = [];
        }
        for ($x = 0; $x < count($array); $x++) {
            $card = Utils::replaceContentsAdminArticleItem(file_get_contents("../html/admin-tile.html"), $array[$x]);
            array_push($articlesList, $card);
        }
        return implode($articlesList);
    }

    public static function validateInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function unsetAll($variablesToUnset)
    {
        foreach ($variablesToUnset as $var) {
            unset($_SESSION[$var]);
        }
    }

    public static function getArticleFromId($id)
    {
        return Article::fetch($id);
    }

    public static function generateRandomString($length)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public static function createDate($day, $month, $year)
    {
        return $year . "-" . $month . "-" . $day . " 00:00:00";
    }

    public static function uploadImage($target_dir, $imageReq)
    {
        $target_file = Utils::generateRandomString(10);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($imageReq["name"], PATHINFO_EXTENSION));
        $target_file .= "." . $imageFileType;
        $check = getimagesize($imageReq["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            return ["success" => false, "error" => "il file caricato non è un'immagine."];
            $uploadOk = 0;
        }

        if ($imageReq["size"] > 5000000) {
            return ["success" => false, "error" => "il file caricato è troppo grande."];
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            return ["success" => false, "error" => "solo i formati JPG, JPEG e PNG sono supportati."];
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            return ["success" => false, "error" => "il tuo file non è stato caricato."];
        } else {
            if (move_uploaded_file($imageReq["tmp_name"], $target_dir . $target_file)) {
                return ["success" => true, "url" => $target_file];
            } else {
                return ["success" => false, "error" => "si è verificato un errore durante il caricamento del file."];
            }
        }
    }
}
