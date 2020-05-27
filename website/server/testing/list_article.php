<?php
    // include_once("../session_manager.php");
    include_once("../db_manager.php");
    include_once("../utils.php");
    
    include_once("../models/article.php");

    print_r(Article::list());
?>