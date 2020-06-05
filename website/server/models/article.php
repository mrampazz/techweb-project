<?php

include_once("base.php");

class Article extends Base 
{
    const CONTENT_KEY = "content";
    const BRAND_KEY = "brand";
    const MODEL_KEY = "model";
    const INITIAL_PRICE_KEY = "initial_price";
    const LINK_KEY = "buy_link";
    const LAUNCH_DATE_KEY = "launch_date";
    const IMAGE_KEY = "main_image";
    const VOTES_TOTAL_KEY = "votes_count";
    const VOTES_POSITIVE_KEY = "votes_positive";

    const TABLE_NAME = "Article";

    var $votesTotal, $votesPositive, $content, $brand, $model, $initialPrice, $link, $launchDate, $image;
 
    public function __set( $name, $value ) {
        switch ($name)
        {
            case self::VOTES_TOTAL_KEY: 
                $this->votesTotal = $value;
                break;
            case self::VOTES_POSITIVE_KEY: 
                $this->votesPositive = $value;
                break;
            case self::CONTENT_KEY: 
                $this->content = $value;
                break;
            case self::BRAND_KEY: 
                $this->brand = $value;
                break;
            case self::MODEL_KEY: 
                $this->model = $value;
                break;
            case self::INITIAL_PRICE_KEY: 
                $this->initialPrice = $value;
                break;
            case self::LINK_KEY: 
                $this->link = $value;
                break;
            case self::LAUNCH_DATE_KEY: 
                $this->launchDate = $value;
                break;
            case self::IMAGE_KEY: 
                $this->image = $value;
                break;
            default: 
                parent::__set($name, $value);
                break;
        }
    }

    public function saveInDB() {
        $dbman = DBManager::getInstance();
        $insertQuery = "INSERT INTO ".(self::TABLE_NAME)." (".(self::CONTENT_KEY).", ".(self::BRAND_KEY).", ".(self::MODEL_KEY).", ".(self::INITIAL_PRICE_KEY).", ".(self::LINK_KEY).", ".(self::LAUNCH_DATE_KEY).", ".(self::IMAGE_KEY).") ";
        $insertQuery .= "VALUES ('".$this->content."', '".$this->brand."', '".$this->model."', ".$this->initialPrice.", '".$this->link."', '".$this->launchDate."', '".$this->image."');";
        return $dbman->query($insertQuery);
    }

    public function updateInDB() {
        $dbman = DBManager::getInstance();
        $insertQuery = "UPDATE ".(self::TABLE_NAME)." SET  ".(self::CONTENT_KEY)."='".$this->content."', ".(self::BRAND_KEY)."='".$this->brand."', ".(self::MODEL_KEY)."='".$this->model."', ".(self::INITIAL_PRICE_KEY)."=".$this->initialPrice.", ".(self::LINK_KEY)."='".$this->link."', ".(self::LAUNCH_DATE_KEY)."='".$this->launchDate."', ".(self::IMAGE_KEY)."='".$this->image."' ";
        $insertQuery .= " WHERE id=".$this->id;
        return $dbman->query($insertQuery);
    }

    public static function list($search=null, $brand=null, $order = null, $asc = "ASC")
    {
        $dbman = DBManager::getInstance();
        $whereClause = "1";

        if ($brand != null)
            $whereClause = $whereClause." AND ".(self::TABLE_NAME).".".self::BRAND_KEY." LIKE '$brand'";
        
        if ($search != null)
            $whereClause = $whereClause." AND (".(self::TABLE_NAME).".".self::MODEL_KEY." LIKE '%{$search}%' OR ".(self::TABLE_NAME).".".self::BRAND_KEY." LIKE '%{$search}%')";

        $orderClause = "";
        if ($order != null)
        {
            $orderClause = " ORDER BY {$order} {$asc} ";
        }

        $queryString = "SELECT Article.*, count(Vote.id) AS votes_count, sum(Vote.positive) as votes_positive FROM ".(self::TABLE_NAME)." LEFT JOIN Vote ON (".(self::TABLE_NAME).".id=Vote.article_id) WHERE ".$whereClause." GROUP BY Article.id {$orderClause};";
        $results = $dbman->query($queryString, Article::class);
        return $results;
    }

    public static function getUserVotes($userId) {
        $dbman = DBManager::getInstance();
        return $dbman->query("SELECT * FROM Vote WHERE user_id = ".$userId);
    }

    public static function fetch($id)
    {
        $dbman = DBManager::getInstance();
        return $dbman->fetchObject(Article::class, $id);
    }

    public static function getLaunchDateList() 
    {
        $dbman = DBManager::getInstance();
        return $dbman->query("SELECT DISTINCT YEAR(".(self::LAUNCH_DATE_KEY).") as anno FROM ".(self::TABLE_NAME));
    }

    public static function addVote($userId, $articleId, $vote) 
    {
        $dbman = DBManager::getInstance();
        $articleId = $articleId;
        $result = $dbman->query("SELECT * FROM Vote WHERE user_id =".$userId." AND article_id = ".$articleId);
        if (count($result) != 0) {
            if ($result[0]->positive != $vote) {
                return $dbman->query("UPDATE Vote SET positive={$vote} WHERE user_id = {$userId} AND article_id = {$articleId}");
            } else {
                return $dbman->query("DELETE FROM Vote WHERE user_id = {$userId} AND article_id = {$articleId}");
            }
        } else {
            return $dbman->query("INSERT INTO Vote (`id`, `user_id`, `article_id`, `created_at`, `updated_at`, `positive`) VALUES (NULL, {$userId}, {$articleId}, current_timestamp(), current_timestamp(), {$vote})");
        }
    }

    public static function getModelsList(){
        $dbman = DBManager::getInstance();
        return $dbman->query("SELECT DISTINCT ".(self::BRAND_KEY)." as brand FROM ".(self::TABLE_NAME));
    }
}

?>