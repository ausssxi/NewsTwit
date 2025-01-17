<?php
ini_set('display_errors', 1);

session_start();

header("Content-type: text/html; charset=utf-8");

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/vendor/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;

$objTwitterConection = new TwitterOAuth($sTwitterConsumerKey, $sTwitterConsumerSecret);

$aTwitterRequestToken = $objTwitterConection->oauth('oauth/request_token', array('oauth_callback' => $sTwitterCallBackUri));

$_SESSION['twOauthToken'] = $aTwitterRequestToken['oauth_token'];
$_SESSION['twOauthTokenSecret'] = $aTwitterRequestToken['oauth_token_secret'];

$sTwitterRequestUrl = $objTwitterConection->url('oauth/authenticate', array('oauth_token' => $_SESSION['twOauthToken']));

//Twitter認証画面へリダイレクト
header('location: '.$sTwitterRequestUrl);
?>
