<?php

require "MyCurl.class.php";
const BASE_URL = "http://simon.ist.rit.edu:8080/AreaDemo/resources/AreaCalculator/";
$results = file_get_contents(BASE_URL . "Hello/");
echo "Hello: <pre>"
. htmlentities($results) .
"</pre><hr />";

$results = file_get_contents(BASE_URL . "Hello/Kirtana/");
echo "Hello: <pre>"
. htmlentities($results) .
"</pre><hr />";

//In the WADL GET is specified for rectangle, therefore send parameters in query string
//<method id="calcRectangleAreaXML" name="GET">
$results = file_get_contents(BASE_URL . "Rectangle/?width=100&length=100");
echo "Rectangle: <pre>"
. htmlentities($results) .
"</pre><hr />";

$results = MyCurl::getRemoteFile(BASE_URL . "Circle/?radius=100");
echo "Curl Circle: <pre>"
. htmlentities($results) .
"</pre><hr />";

$results = MyCurl::getRemoteFile(BASE_URL . "Rectangle/?width=100&length=100", "application/json");
echo "Rectangle: <pre>"
. htmlentities($results) .
"</pre><hr />";

// $data = [
//   "name" => "foo",
//   "id" => 7
// ];
// $results = MyCurl::setPost(BASE_URL, http_build_query($data));
// $results = MyCurl::setPut(BASE_URL, json_encode($data));
