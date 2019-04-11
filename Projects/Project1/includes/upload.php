<?php
//Picture uploader helper class
session_start();
require "../classes/DB.class.php";
$db = new DB();

$target_dir = "/home/MAIN/ks3057/Sites/756/Projects/Project1/teampictures/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // $db->run('update server_team set picture = ? where id = ?', [basename($_FILES["fileToUpload"]["name"]), $_GET['tid']]);
        // echo $_GET['tid'];
        echo basename($_FILES["fileToUpload"]["name"]);
        $res = $db->addPicture(basename($_FILES["fileToUpload"]["name"]), $_SESSION['picture']);
        echo "The file ". basename($_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $_SESSION['picture'] = "";
        header("Location: ../admin.php");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
