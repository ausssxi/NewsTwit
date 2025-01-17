<?php

session_start();

header("Content-type: text/html; charset=utf-8");

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/vendor/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;

if (empty($_SESSION['twOauthToken']) || empty($_SESSION['twOauthTokenSecret']) || empty($_REQUEST['oauth_token']) || empty($_REQUEST['oauth_verifier'])) {
    echo 'error token!!';
    exit;
}

if ($_SESSION['twOauthToken'] !== $_REQUEST['oauth_token']) {
    echo 'error token incorrect!!';
    exit;
}

$objTwitterConection = new TwitterOAuth($sTwitterConsumerKey, $sTwitterConsumerSecret, $_SESSION['twOauthToken'], $_SESSION['twOauthTokenSecret']);

$_SESSION['twAccessToken'] = $objTwitterConection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));

header('location: member.php');
