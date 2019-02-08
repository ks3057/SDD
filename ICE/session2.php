<?php
// session_name("Kirtana session"); //OPTIONAL. Creates a cookie different than PHPSESSID
//complete list of options: http://php.net/manual/en/session.configuration.php
$options = [
  "name" => "KS",
  "gc_maxlifetime" => 60 * 10
];
session_start($options);
//echo print_r($_POST);

if (isset($_POST["submit"])) {
    $_SESSION["name"] = $_POST["name"];
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Session 2</title>
</head>

<body>
  <?php
  if (isset($_SESSION["name"])) {
      echo "Hi, ".$_SESSION["name"].".";
      echo "<a href='session3.php'>Next</a>";
  } else {
      echo "Who are you? <a href='session1.php'> Back to Login </a>";
  }
  ?>

</body>
</html>
