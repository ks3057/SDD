<?php
session_start();
$_SESSION['picture']= $_GET['tid'];
require_once "../classes/DB.class.php";
$db = new DB();
$path = "../teampictures/";
if (!isset($_SESSION["loggedIn"])) {
    $_SESSION["redirect"] = true;//redirect set as session variable
    header("Location: index.php");
    exit();
}
  include "nav.php";
?>
<html>
<head>
  <meta charset="utf-8">
	<title>Add Picture</title>
  <html>
  <head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container">
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload" />
        <input type="submit" value="Upload Image" name="submit" />
    </form>
    <?php
    $pic = $db->run('select * from server_team where id = ?', [$_SESSION['picture']])->fetch();
    if (empty($pic['picture'])) {
        echo " No pic";
    } else {
        $image = $path.$pic['picture'];
        echo '<img src="'.$image.'" alt="team picture" height="400"/>';
    }
    ?>
  </div>
</body>
</html>
