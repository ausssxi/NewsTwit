<?php

session_start();

header("Content-type: text/html; charset=utf-8");

$_SESSION = array();
$_COOKIE = array();

setcookie("PHPSESSID", '', time() - 1800, '/');

session_destroy();

header("Location: index.php");
exit();
?>
