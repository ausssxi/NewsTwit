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
word_more("SELECT news_id, title, image, up FROM news WHERE site_domain_name = '$_GET[site]' ORDER BY up DESC, news_id DESC LIMIT 20 OFFSET ${offset}")
?>
