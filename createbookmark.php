<?php
session_start();
require_once('twitteroauth.php');
require_once('twitterauthinfo.php');

  if(isset($_GET['oauth_verifier'])) {
    // Callback
    $req = $_SESSION['token'];
    $to1 = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $req['oauth_token'], $req['oauth_token_secret']);
    $access_token = $to1->getAccessToken($_GET['oauth_verifier']);
    $ac_token = $access_token['oauth_token'];
    $ac_token_secret = $access_token['oauth_token_secret'];

    if(empty($ac_token)) {
        header("Location: " . TOP_URL);
        exit();
    }


    echo "Bookmarkletを生成しました。<BR><BR>";
    echo "下のリンクをブックマークバーにD&Dしたり、お気に入りに入れたりして使って下さい。<BR>";
    echo "<p><font size=+3>";
    echo "<a href=\"javascript:var%20userinput=prompt('%E3%82%B3%E3%83%A1%E3%83%B3%E3%83%88%E3%82%92%E5%85%A5%E5%8A%9B%EF%BC%88%E7%A9%BA%E7%99%BD%E5%8F%AF%EF%BC%89','');if(userinput!=null){location.href=('" . PATH_TO_SUBMIT . "?token=${ac_token}&secret=${ac_token_secret}'+'&url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title)+'&text='+encodeURIComponent(userinput));};\">Bween</a>";
    echo "</font></p>";
    echo "<BR>";
    echo "<a href='" . TOP_URL . "'>TOPへ戻る</a>";
  }
  else {
    // Authorize
    $to2 = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
    $request_token = $to2->getRequestToken(OAUTH_CALLBACK);
    $_SESSION['token'] = $request_token;
    $auth_url = $to2->getAuthorizeURL($request_token, FALSE);
    header("Location: ${auth_url}");
  }
