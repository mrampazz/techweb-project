<?php

include_once("base.php");

class FAQ extends Base 
{
    const CONTENT_KEY = "content";
    const TITLE_KEY = "title";

    const TABLE_NAME = "FAQ";

    var $content, $title;
 
    public function __set( $name, $value ) {
        switch ($name)
        {
            case self::CONTENT_KEY: 
                $this->content = $value;
                break;
            case self::TITLE_KEY: 
                $this->title = $value;
                break;
            default: 
                parent::__set($name, $value);
                break;
        }
    }

    public static function getFAQ()
    {
        $dbman = DBManager::getInstance();
        return $dbman->query("SELECT * FROM FAQ ORDER BY created_at ASC;", FAQ::class);
    }

    public static function createFAQ($t, $c)
    {
        $dbman = DBManager::getInstance();
        return $dbman->query("INSERT INTO ".self::TABLE_NAME." (`".self::CONTENT_KEY."`, `".self::TITLE_KEY."`) VALUES ('{$c}', {$t})");
    }

 }

?>