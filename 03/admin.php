<?php
//required if the session is active for more than 10mins but cookie has expired
$message = "a long time back";
session_start();
if (!isset($_SESSION["loggedIn"])) {
    $_SESSION["redirect"] = true;//redirect set as session variable
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>HW2 Admin</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body id="admin">
  <?php
      if (isset($_COOKIE["loggedIn"])) {
          $message = $_COOKIE["loggedIn"];
      }
      echo "You logged in ".$message."<br />";
      echo "<a href='logout.php?logOut=true'>Log out</a>"; //logout only if the link is clicked
  ?>

</body>
</html>
