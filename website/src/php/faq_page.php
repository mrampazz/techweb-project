<?php
    $list = Utils::generateFaqList(FAQ::getFAQ());
    $output = str_replace("{faq-items}", $list, $output);
?>