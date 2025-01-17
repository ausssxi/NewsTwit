<?php
require "fuzzy_time.php";
$page = ($_GET['page'] - 1) * 15;
$userData = array();
$mysqli = new mysqli('localhost', 'root', 'password', 'NewsTwit');
$mysqli->set_charset("utf8");
$result = $mysqli->query("SELECT comment_id, tweet, name, screen, icon, up FROM comment WHERE news_id = '" . $_GET["id"] . "' ORDER BY up DESC, news_id DESC LIMIT " . $page . "," . $_GET['per_page'] . "");
while ($row = $result->fetch_assoc()) {
    $up = convert_to_fuzzy_time($row["up"]);
    $userData[]=array('id'=>$row['comment_id'], 'tweet'=>$row['tweet'], 'name'=>$row['name'], 'screen'=>$row['screen'], 'icon'=>$row['icon'], 'up'=>$up);
}
header('Content-type: application/json');
echo json_encode($userData, JSON_UNESCAPED_UNICODE);
?>
