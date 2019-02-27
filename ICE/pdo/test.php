<?php
require_once("/home/MAIN/ks3057/Sites/db_conn.php");
$data = array();
$dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql  = "SELECT * FROM people where PersonID=:id";

//1
// $stmt = $dbh->query($sql);
// while ($row = $stmt->fetch()) {
//     echo $row['PersonID'] . "\n";
// }

//2
// $id = 2;
// $stmt = $dbh->prepare($sql);
// $stmt->execute(['id'=>1]);
// $user = $stmt->fetch();
// print_r($user);



// $stmt = $dbh->prepare($sql);
// $stmt->bindParam(':Id', $id, PDO::PARAM_INT);
// $stmt->execute();
//
// print_r($result);
// while ($row = $stmt->fetch()) {
//     $data[] = $row;
// }
// $id = '123test';
