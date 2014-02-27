<?php
require_once("twitteroauth.php");
require_once('twitterauthinfo.php');

if(isset($_GET['token'], $_GET['secret'], $_GET['url'], $_GET['title'], $_GET['text'])) {
	$access_token = $_GET['token'];
	$access_token_secret = $_GET['secret'];
	$url = $_GET['url'];
	$title = $_GET['title'];
	$text = $_GET['text'];
} else {
	echo "Failed.";
	exit();
}
if($text === "")
	$text = "Browsing";

$over_len = mb_strlen($text, 'UTF-8') + 1 + mb_strlen($title, 'UTF-8') + 1 + 23 - 140;
if($over_len > 0)
	$title = mb_substr($title, 0, mb_strlen($title, 'UTF-8') - $over_len - 3, 'UTF-8') . "...";

$text = $text . "：" . $title . " " . $url;

$to = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
$result = $to->post('statuses/update', ['status' => $text]);
header("Location: " . $url);
