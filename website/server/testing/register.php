<?php
    include_once("../models/models.php");
    include_once("../session_manager.php");
    include_once("../db_manager.php");
    
    $manager = DBManager::getInstance();
    $manager->register('test', 'testtest', 'tester', 'tester', 'fdsf@sdfmc.com');
?>