<?php
require_once "config.php";
try {
    $accessToken = $helper->getAccessToken();
} catch (\Facebook\Exceptions\FacebookResponseException $e) {
    // echo "Respose Exception: " . $e->getMessage();
    exit();
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    // echo "SDK Exception: " . $e->getMessage();
    exit();
}

if (!$accessToken) {
    header('Location: index.php');
    exit();
}

$oAuth2Client = $FB->getoAuth2Client();
if (!$accessToken->isLongLived()) {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
}

$response = $FB>get("/me?fields=id,name,email");
$userData = $response->getGraphNode()->asArray();
var_dump($userData);
