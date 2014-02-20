<?php
require_once("twitteroauth.php");
require_once('twitterauthinfo.php');

if(isset($_GET['token'])) {
        $access_token = $_GET['token'];
}
if(isset($_GET['secret'])) {
        $access_token_secret = $_GET['secret'];
}
if(isset($_GET['url'])) {
        $url = $_GET['url'];
}
if(isset($_GET['title'])) {
        $title = $_GET['title'];
}
if(isset($_GET['text'])) {
        $text = $_GET['text'];
}
if($text === "")
{
        $text = "Browsing";
}

$over_len = mb_strlen($text, 'UTF-8') + 1 + mb_strlen($title, 'UTF-8') + 1 + 23 - 140;
if($over_len > 0) {
        $title = mb_substr($title, 0, mb_strlen($title, 'UTF-8') - $over_len - 3, 'UTF-8') . "...";
}

$text = $text . "：" . $title . " " . $url;

$to = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
$result = $to->post('statuses/update', ['status' => $text]);
header("Location: " . $url);
?>
