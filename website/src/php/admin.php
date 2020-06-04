<?php
if(isset($_SESSION['updated-correctly'])){
    $page = file_get_contents("../html/message-box.html");
    $output = str_replace("{message-box}",$page,$output);
    $output = str_replace("{message-box-class}","success-message-box",$output);
    $output = str_replace("{message-box-title}","Telefono aggiornato!",$output);
    $output = str_replace("{message-box-text}","Le informazioni sul telefono sono state correttamente aggiornate.",$output);
    unset($_SESSION['updated-correctly']);
}
else if(isset($_SESSION['inserted-correctly'])){
        $page = file_get_contents("../html/message-box.html");
        $output = str_replace("{message-box}",$page,$output);
        $output = str_replace("{message-box-class}","success-message-box",$output);
        $output = str_replace("{message-box-title}","Telefono inserito!",$output);
        $output = str_replace("{message-box-text}","Il nuovo telefono è stato correttamente inserito.",$output);
        unset($_SESSION['inserted-correctly']);
}
else{
    $output = str_replace("{message-box}","",$output);
}

$list = Utils::getArticles(null, null, null);
$articlesList = Utils::generateAdminArticlesList($list);

if ($articlesList != '') {
    $output = str_replace("{articles}", $articlesList, $output);
} else {
    $output = str_replace("{articles}", "Nessun articolo trovato.", $output);
}
?>