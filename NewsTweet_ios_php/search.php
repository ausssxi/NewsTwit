<?php
require "fuzzy_time.php";
$page = ($_GET['page'] - 1) * 10;
$word = $_GET['word'];
$sql;
$userData = array();
$mysqli = new mysqli('localhost', 'root', 'password', 'NewsTwit');
$mysqli->set_charset("utf8");
$word = mb_convert_kana($word,"s");
if (strpos($word,' ') !== false) {
    $keywords = preg_split("/[\s]+/",$word);
    $tmp = array();
    foreach($keywords as $keyword) {
        if($keyword != "") {
            $tmp[] = " (title LIKE '%" . $keyword . "%' OR description LIKE '%" . $keyword . "%') ";
        }
    }
    $sql = "SELECT news_id, count(*) AS COUNT FROM comment WHERE news_id IN (SELECT news_id FROM news WHERE ";
    if(count($tmp) > 0) {
        $sql .= implode("AND", $tmp);
        $sql .= ") GROUP BY news_id ORDER BY COUNT DESC, news_id DESC LIMIT " . $page . "," . $_GET['per_page'] . "";
    }
} else {
    $sql = "SELECT news_id, count(*) AS COUNT FROM comment WHERE news_id IN (SELECT news_id FROM news WHERE title LIKE '%" . $word . "%' OR description LIKE '%" . $word . "%') GROUP BY news_id ORDER BY COUNT DESC, news_id DESC LIMIT " . $page . "," . $_GET['per_page'] . "";
}
$result_1 = $mysqli->query($sql);
while ($row = $result_1->fetch_assoc()) {
    $id = $row["news_id"];
    $result_2 = $mysqli->query("SELECT COUNT(*) FROM comment WHERE news_id = '" . $id . "'");
    while ($count = $result_2->fetch_row()) {
        $tweet_count = $count[0];
    }
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
        $userData[] = array('id'=>$id, 'title'=>$title, 'url'=>$row['url'], 'image'=>$image, 'description'=>$row['description'], 'site_domain_name'=>$row['site_domain_name'], 'up'=>$up, 'tweet_count'=>$tweet_count);
    }
}
header('Content-type: application/json');
echo json_encode($userData, JSON_UNESCAPED_UNICODE);
?>
