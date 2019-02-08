<?php
//secure: to be accessed only with https
//name, value, expiration time, path, domain
$expire = time() + 60 * 60 * 24 * 7; //expire in one week
$path = "/";
//$path = "/~ks3057/"
$domain = "localhost";
$secure = false;
$http = true; // disable access by javascript
setcookie("test_cookie", "our first cookie! ", $expire, $path, $domain, $secure, $http);
?>

<!DOCTYPE html>
<html>

</html>
