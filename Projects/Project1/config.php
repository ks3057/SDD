<?php
require_once "Facebook/autoload.php";

$FB = new \Facebook\Facebook([
  'app_id' => '638943989896524',
  'app_secret' => 'e54c7b8c0b372779097215dde3068117',
  'default_graph_version' => 'v2.10'
]);

$helper = $FB->getRedirectLoginHelper();
