<?php 
class Helper{

public static function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return NULL;
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

public static function CleanInitialPage($page){
    $pageHalf = explode("<tbody>", $page);
    $dataTable = explode("</tbody>", $pageHalf[2]);
    echo($pageHalf[0]);

    $cleanedDataTable = $dataTable[0];
    
    return $cleanedDataTable;
}

public static function SeperateTables($cleanedPage){
    $tables = explode("<tr>", $cleanedPage);
    return $tables;
}

 public static function GetStringIfExists($string, $array){
    $x = '';
    for ($i = 0; $i < count($array); $i++) {
        if (!empty(strstr($string, $array[$i]))) {
            $x = $array[$i];
            break;
        }
    }

    return $x;
 }

}
?>