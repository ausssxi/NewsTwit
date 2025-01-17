<?php
require_once(__DIR__ . '/vendor/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

$options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf8'");
error_reporting(E_ALL & ~E_NOTICE);
try {
    $pdo = new PDO("mysql:dbname=NewsTwit; host=localhost; charset=utf8mb4", "root", "nanoninaze", $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit();
}

if ($_POST['comment'] && $_POST['user_id']) {
    if ($_POST['bool']) {
        $consumerKey = "FH0NETnaKpBKLRZI8203prRIT";
        $consumerSecret = "gFQOm2j1admDvprpa5ACFUCcZ2rR3xlwKZLyPxgjhLemK6dSzQ";
        $result = $pdo->query("SELECT access_token_key, access_token_secret FROM user WHERE user_id = '" . $_POST['user_id'] . "'");
        foreach($result as $value) {
		        $accessToken = $value['access_token_key'];
            $accessTokenSecret = $value['access_token_secret'];
	      }
        $twitter = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
        $twitter->post("statuses/update", array("status" => $_POST["comment"] . " #NewsTweet\nhttp://newstweet.jp/news/" . $_POST["news_id"]));
    }
    $pdo->query("INSERT INTO comment_self SET news_id = '" . $_POST["news_id"] . "', user_id = '" . $_POST["user_id"] . "', comment = '" . $_POST["comment"] . "', up = NOW()");
} elseif ($_POST['comment_self']) {
    $pdo->query("DELETE FROM comment_self WHERE comment_id = '" . $_POST["comment_self"] . "'");
} elseif ($_POST['comment_id']) {
    $pdo->query("DELETE FROM comment WHERE comment_id = '" . $_POST["comment_id"] . "'");
} elseif ($_POST['message']) {
    $to = "ausssxi@gmail.com";
    $title = "NewsTweetからのご意見";
    $message = $_POST['message'];
    $headers = "From: from@newstwit.jp";
    mb_send_mail($to, $title, $message, $headers, '-f ' . 'from@newstweet.jp');
}
