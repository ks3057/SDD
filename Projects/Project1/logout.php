<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
}
define('ROOT_DIR', '/home/MAIN/ks3057/Sites/756/Projects/Project1/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>LogOut</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php
  //SESSION DESTROY
    $logfile = fopen(ROOT_DIR.'error/error_log.txt', "a") or die("Unable to open file!");
    fwrite($logfile, "\n".$_SESSION['username']." ".date("M,d,Y h:i:s A") ."\n". "logout");
    fclose($logfile);
      unset($_SESSION["loggedIn"]); //unset session variable
      if (isset($_COOKIE[session_name()])) {
          setcookie(session_name(), "", time() - 3600, "/"); //remove session cookie
      }
      $_SESSION = array(); //clear session array

      session_destroy(); // destroy the session
    header("Location: index.php");
    exit();
  ?>

</body>
</html>
