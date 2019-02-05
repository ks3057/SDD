<?php
$page_display = "Invalid login"; //default login message
session_start();

if (isset($_SESSION["redirect"])) {
    $page_display = "You need to login";
    unset($_SESSION["redirect"]); // redirect should be false in login page
} elseif (isset($_SESSION["loggedIn"])) {
    header("Location: admin.php");
    exit(); //prevent code below from executing after redirection
} else {
    if (isset($_GET["user"]) and isset($_GET["password"])) {
        if ($_GET["user"] == "admin" and $_GET["password"] == "password") {
            $_SESSION["loggedIn"] = true;
            $page_display = "Logged in";
            $expire = time() + 60 * 10; //expire in 10mins
            // $path = "/";
            // $domain = "localhost";
            $path = "/~ks3057/756/03/";
            $domain = "serenity.ist.rit.edu";
            $today = date("F j, Y g:i a");
            setcookie("loggedIn", $today, $expire, $path, $domain);
            header("Location: admin.php");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>HW2 Login</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body id="login">
  <p>
    <?php echo $page_display ?>
  </p>
</body>
</html>
