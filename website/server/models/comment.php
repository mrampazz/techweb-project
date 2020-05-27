<?php

include_once("base.php");

class Comment extends Base 
{
    const CONTENT_KEY = "content";
    const USER_ID_KEY = "user_id";
    const ARTICLE_ID_KEY = "article_id";
    const USER_FULLNAME_KEY = "user_fullname";


    const TABLE_NAME = "Comment";

    var $content, $userId, $articleId, $userFullName;
 
    public function __set( $name, $value ) {
        switch ($name)
        {
            case self::CONTENT_KEY: 
                $this->name = $value;
                break;
            case self::USER_ID_KEY: 
                $this->userId = $value;
                break;
            case self::ARTICLE_ID_KEY: 
                $this->articleId = $value;
                break;
            case self::USER_FULLNAME_KEY: 
                $this->userFullName = $value;
                break;
            default: 
                parent::__set($name, $value);
                break;
        }
    }

    public static function getCommentsFor($articleId)
    {
        $dbman = DBManager::getInstance();
        return $dbman->query("SELECT *, CONCAT(".User::TABLE_NAME.".".User::NAME_KEY.", ' ', ".User::TABLE_NAME.".".User::SURNAME_KEY.") as user_fullname FROM ".self::TABLE_NAME." JOIN ".User::TABLE_NAME." on ".Comment::TABLE_NAME.".".Comment::USER_ID_KEY." = ".User::TABLE_NAME.".".Base::ID_KEY." WHERE ".self::TABLE_NAME.".".self::ARTICLE_ID_KEY." = {$articleId} ORDER BY ".self::TABLE_NAME.".".Base::CREATED_KEY." DESC;", Comment::class);
    }

    public static function createComment($userId, $articleId, $content)
    {
        $dbman = DBManager::getInstance();
        return $dbman->query("INSERT INTO ".self::TABLE_NAME." (`".self::CONTENT_KEY."`, `".self::USER_ID_KEY."`, `".self::ARTICLE_ID_KEY."`) VALUES ('{$content}', {$userId}, {$articleId})");
    }

    public static function getAvatar($id)
    {
        $dbman = DBManager::getInstance();
        return $dbman->query("SELECT avatar_url FROM User WHERE User.id='$id'");
    }

 }

?>