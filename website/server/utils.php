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

    public static function createDate($day,$month,$year){
        return $year."-".$month."-".$day." 00:00:00";
    }

    public static function uploadImage($target_dir, $imageReq, $prepath = "") {
        $target_file = $target_dir . Utils::randomString(10);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($imageReq["name"],PATHINFO_EXTENSION));
        $target_file .= "." . $imageFileType;
        $check = getimagesize($imageReq["tmp_name"]);
        if($check !== false) {
           $uploadOk = 1;
        } else {
            return ["success" => false, "error" => "Error, file is not an image."];
            $uploadOk = 0;
        }

        if ($imageReq["size"] > 5000000) {
            return ["success" => false, "error" => "Error, your file is too large."];
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            return ["success" => false, "error" => "Error, only JPG, JPEG, PNG files are allowed."];
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            return ["success" => false, "error" => "Error, your file was not uploaded."];
        } else {
            if (move_uploaded_file($imageReq["tmp_name"], $prepath.$target_file)) {
                return ["success" => true, "url" => $target_file];
            } else {
                return ["success" => false, "error" => "Sorry, there was an error uploading your file."];
            }
        }
    }
}
