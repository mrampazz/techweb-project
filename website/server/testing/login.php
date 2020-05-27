<?php
    include_once("../models/models.php");
    include_once("../session_manager.php");
    include_once("../db_manager.php");
    
    $manager = DBManager::getInstance();
    $res = $manager->login('test', 'testtest');
    echo "UserId   ".$res;
    echo "\r\n SEssion ". (SessionManager::isUserLogged());
    echo "\r\n Publish ". (SessionManager::userCanPublish());
    echo "\r\n Username ". (SessionManager::getUsername());
    echo "<br /><br />";
    print_r(User::getUser($res));
?>