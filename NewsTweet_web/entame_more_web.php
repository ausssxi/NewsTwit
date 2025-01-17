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
popular_more("SELECT news_id FROM news_count WHERE category = 2 ORDER BY count DESC, news_id DESC LIMIT 20 OFFSET ${offset}")
?>
