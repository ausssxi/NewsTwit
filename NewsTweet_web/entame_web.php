<?php
ini_set('display_errors', "On");
session_start();
require "fuzzy_time.php";
require __DIR__ . '/vendor/autoload.php';
require_once "functions.php";
function user_agent() {
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if ((strpos($agent, 'Android') !== false) && (strpos($agent, 'Mobile') !== false) || (strpos($agent, 'iPhone') !== false)) {
        return true;
    }
}
$mysqli = new mysqli('localhost', 'root', 'nanoninaze', 'NewsTwit');
$mysqli->set_charset("utf8mb4");
head("芸能・スポーツ", "entame");
header_html();
toggle();
popular_main("芸能・スポーツ", "entame", 2);
ads_728();
footer();
ads_320();
?>
<script type="text/javascript" src="/jquery-3.3.1.min.js"></script>
<?php
popular_java(2, "entame");
?>
