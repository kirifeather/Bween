<?php
session_start();
require_once('twitteroauth.php');
require_once('twitterauthinfo.php');

  if(isset($_GET['oauth_verifier'])) {
    $req = $_SESSION['token'];
    $to1 = new TwitterOAuth($consumer_key, $consumer_secret, $req['oauth_token'], $req['oauth_token_secret']);
    $access_token = $to1->getAccessToken($_GET['oauth_verifier']);
    $ac_token = $access_token['oauth_token'];
    $ac_token_secret = $access_token['oauth_token_secret'];

    echo "<a href=\"javascript:var%20userinput=prompt('%E3%82%B3%E3%83%A1%E3%83%B3%E3%83%88%E3%82%92%E5%85%A5%E5%8A%9B%EF%BC%88%E7%A9%BA%E7%99%BD%E5%8F%AF%EF%BC%89','');if(userinput!=null){location.href=('http://kiri-bween.appspot.com/submit.php?token=$ac_token&secret=$ac_token_secret'+'&url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title)+'&text='+encodeURIComponent(userinput));};\">Bween</a>";
  }
  else {
    $to2 = new TwitterOAuth($consumer_key, $consumer_secret);
    $request_token = $to2->getRequestToken('http://kiri-bween.appspot.com/createbookmark.php');
    $_SESSION['token'] = $request_token;
    $auth_url = $to2->getAuthorizeURL($request_token);
    header("Location: $auth_url");
  }
?>