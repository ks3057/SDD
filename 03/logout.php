<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>HW2 LogOut</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php
  if (isset($_GET['logOut'])) {

      //SESSION
      unset($_SESSION["loggedIn"]); //unset session variable
      if (isset($_COOKIE[session_name()])) {
          setcookie(session_name(), "", time() - 3600, "/"); //remove session cookie
      }
      unset($_COOKIE[ session_name() ]);
      $_SESSION = array(); //clear session array

      //COOKIE
      $path = "/~ks3057/756/03/";
      $domain = "serenity.ist.rit.edu";
      if (isset($_COOKIE["loggedIn"])) {
          setcookie("loggedIn", "", time() - 60 * 60 * 24 * 7, $path, $domain); //expire cookie
      }
      unset($_COOKIE[ "loggedIn" ]); //unset cookie variable

      session_destroy(); // destroy the session
      echo "You are logged out.";
  } else {
      echo "Logout can only be accessed via link in admin page";
  }
  ?>

</body>
</html>
