<?php

session_start();

header("Content-type: text/html; charset=utf-8");

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/vendor/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;

if (empty($_SESSION['twAccessToken'])) {
    echo 'error access token!!';
    exit;
}
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf8'");
error_reporting(E_ALL & ~E_NOTICE);
try {
    $pdo = new PDO("mysql:dbname=NewsTwit; host=localhost; charset=utf8mb4", "root", "password", $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit();
}
$objTwitterConection = new TwitterOAuth($sTwitterConsumerKey, $sTwitterConsumerSecret, $_SESSION['twAccessToken']['oauth_token'], $_SESSION['twAccessToken']['oauth_token_secret']);
$objTwUserInfo = $objTwitterConection->get("account/verify_credentials");
if (isset($_SESSION["id"])) {
    session_regenerate_id(TRUE);
    header("Location: index.php");
    exit();
} else {
    $rows = $pdo->query("SELECT user_id, access_token_key, access_token_secret FROM user WHERE twitter_id = '" . $objTwUserInfo->id . "'");
    if ($rows->rowCount() > 0) {
        foreach($rows as $value) {
            $id =	$value["user_id"];
            $key =	$value["access_token_key"];
            $secret =	$value["access_token_secret"];
  	    }
        if (($_SESSION['twAccessToken']['oauth_token'] != $key) || ($_SESSION['twAccessToken']['oauth_token_secret'] != $secret)) {
            $pdo->query("UPDATE user SET access_token_key = '" . $_SESSION['twAccessToken']['oauth_token'] . "', access_token_secret = '" . $_SESSION['twAccessToken']['oauth_token_secret'] . "' WHERE user_id = '" . $id . "'");
        }
        session_regenerate_id(TRUE);
        $_SESSION["id"] = $id;
        header("Location: index.php");
        exit();
    } else {
        $icon = $objTwUserInfo->id . ".jpg";
        $data = file_get_contents($objTwUserInfo->profile_image_url_https);
        file_put_contents("/var/www/html/thumbnail/" . $icon, $data);
        $pdo->query("INSERT INTO user SET twitter_id = '" . $objTwUserInfo->id . "', name = '" . $objTwUserInfo->name . "', screen = '" . $objTwUserInfo->screen_name . "', icon = '" . $icon . "', access_token_key = '" . $_SESSION['twAccessToken']['oauth_token'] . "', access_token_secret = '" . $_SESSION['twAccessToken']['oauth_token_secret'] . "'");
        $rows = $pdo->query("SELECT user_id FROM user WHERE twitter_id = '" . $objTwUserInfo->id . "'");
        foreach($rows as $value) {
            $id =	$value["user_id"];
      	}
        session_regenerate_id(TRUE);
        $_SESSION["id"] = $id;
        header("Location: index.php");
        exit();
    }
}
?>
