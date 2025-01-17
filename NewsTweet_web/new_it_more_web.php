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
$offset = 40 * $_GET['offset'];
$mysqli = new mysqli('localhost', 'root', 'nanoninaze', 'NewsTwit');
$mysqli->set_charset("utf8mb4");
new_more("SELECT news_id, title, url, image, description, site_domain_name, up FROM news WHERE news_id in (SELECT news_id FROM news_to_tag WHERE tag_id = 9081948) ORDER BY news_id DESC LIMIT 40 OFFSET ${offset}")
?>
