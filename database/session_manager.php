<?php

session_start(); // move to layout or somewhere else if necessary

class SessionManager
{
    private const USER_ID_KEY = "user_id";
    private const USERNAME_KEY = "username";
    private const PUBLISH_KEY = "canPublish";

    public const BASE_URL = "http://localhost/flixy/website/public/php/layout.php?page=";

    private function __construct()
    {
    }

    public static function startSessionForUser($userId, $username, $canPublish)
    {
        if (is_int($userId) && $userId >= 0 && is_string($username) && !empty($username))
        {
            $_SESSION[SessionManager::USER_ID_KEY] = $userId;
            $_SESSION[SessionManager::USERNAME_KEY] = $username;
            $_SESSION[SessionManager::PUBLISH_KEY] = $canPublish;
            return true;
        }
        return false;
    }

    public static function isUserLogged()
    {
        return isset($_SESSION[SessionManager::USER_ID_KEY]);
    }

    public static function userCanPublish()
    {
        if (SessionManager::isUserLogged())
            return $_SESSION[SessionManager::PUBLISH_KEY];
        return false;
    }

    public static function getUserId()
    {
        if (SessionManager::isUserLogged())
            return $_SESSION[SessionManager::USER_ID_KEY];
        return null;
    }

    public static function getUsername()
    {
        if (SessionManager::isUserLogged())
            return $_SESSION[SessionManager::USERNAME_KEY];
        return null;
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
    }
}


?>