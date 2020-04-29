<?php
class Utils {
    public static function getMenuLinks($array) {
        $list = [];
        for ($x = 0; $x < count($array); $x++) { 
            $element = "<a class='menu-item' href='{$array->link}'>{$array->name}</a>";
            array_push($list, $element);
        }
        return implode($list);
    }
}
?>