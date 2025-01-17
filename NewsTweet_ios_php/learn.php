<?php
require "fuzzy_time.php";
$page = ($_GET['page'] - 1) * 10;
$userData = array();
$mysqli = new mysqli('localhost', 'root', 'password', 'NewsTwit');
$mysqli->set_charset("utf8");
$result_1 = $mysqli->query("SELECT * FROM `news_count` WHERE `category` = 5 ORDER BY count DESC, news_id DESC LIMIT " . $page . "," . $_GET['per_page'] . "");
while ($row = $result_1->fetch_assoc()) {
    $id = $row["news_id"];
    $count = $row["count"];
    $result_2 = $mysqli->query("SELECT title, url, image, description, site_domain_name, up FROM news WHERE news_id = '" . $id . "'");
    while ($row = $result_2->fetch_assoc()) {
        if (is_null($row["image"])) {
            $image = "noimage.jpeg";
        } else {
            $filename = "/var/www/html/app/" . $row["image"];
            if (file_exists($filename)) {
                $image = "https://newstweet.jp/app/" . $row["image"];
            } else {
                $image = "https://newstweet.jp/app/noimage.jpeg";
            }
        }
        $title = $row["title"];
        if (mb_strlen($title) > 91) {
            $title = mb_substr($title, 0, 91);
            $title = $title. "…";
        }
        $up = convert_to_fuzzy_time($row["up"]);
        $userData[]=array('id'=>$id, 'title'=>$title, 'url'=>$row['url'], 'image'=>$image, 'description'=>$row['description'], 'site_domain_name'=>$row['site_domain_name'], 'up'=>$up, 'tweet_count'=>$count);
    }
}
header('Content-type: application/json');
echo json_encode($userData, JSON_UNESCAPED_UNICODE);
?>
