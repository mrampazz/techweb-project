<?php
    // include_once("../session_manager.php");
    include_once("../db_manager.php");
    include_once("../utils.php");
    
    include_once("../models/article.php");
    // create article
    $art = new Article();
    $art->title = "Test";
    $art->content = "content";
    $art->brand = "alfa";
    $art->model = "mod";
    $art->initialPrice = 12.33;
    $art->link = "link";
    $art->launchDate =  Utils::createDate(10,10,2020);
    $art->image = "url";

    print_r($art);
    echo $art->saveInDB();
    echo "<br /><br /><br />Saved<br /><br /><br />";

    $art->id = 8;

    $conn = DBManager::getInstance();
    $fetched = $conn->fetchObject('Article', $art->id);
    $art->brand = "alfa romeo";
    echo $art->updateInDB();
    echo "<br /><br /><br />Updated<br /><br /><br />";
?>