<?php
ini_set('display_errors', "On");
require "fuzzy_time.php";
require_once "functions.php";
function user_agent() {
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if ((strpos($agent, 'Android') !== false) && (strpos($agent, 'Mobile') !== false) || (strpos($agent, 'iPhone') !== false)) {
        return true;
    }
}
$offset = 20 * $_GET['offset'];
$mysqli = new mysqli('localhost', 'root', 'nanoninaze', 'NewsTwit');
$mysqli->set_charset("utf8mb4");
$keyword  = preg_replace("/( |　)+/u", " ", $_GET['text']);
$array = explode(" ", $keyword);
$keyword_count = count($array);
$sql = null;
for ($i = 0; $i < $keyword_count; $i++) {
    $sql .=  "(title LIKE '%". $array[$i]. "%' ";
    $sql .=  "OR description LIKE '%". $array[$i]. "%'";
    $sql .=  "OR site_domain_name LIKE '%". $array[$i]. "%')";
    if(($i + 1) < $keyword_count) {
        $sql .= "AND ";
    }
}
word_more("SELECT news_id, title, image, site_domain_name, up FROM news WHERE ${sql} ORDER BY up DESC LIMIT 20 OFFSET ${offset}")
?>
