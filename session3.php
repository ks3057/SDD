<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Session 3</title>
</head>

<body>
  <?php

  if (isset($_SESSION["name"])) {
      echo "Hi, ".$_SESSION["name"].".<br />";
      echo "Hah! I remembered your name!";
  };

//session teardown
// 1. unset the session variable
unset($_SESSION["name"]);
//or
//session_unset();

// 2. remove session cookie
setcookie(session_name(), "", time() - 1);
unset($_COOKIE[ session_name() ]);

// 3. end the session on the server
session_destroy();


  ?>

</body>
</html>
