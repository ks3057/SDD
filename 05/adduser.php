<?php

require_once "/home/MAIN/ks3057/Sites/db_conn.php";
require "DB.class.php";

$type = "";

// 1. Open the db connection
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// 2. check the connection
if ($mysqli->connect_error) {
    echo "connection failed: " . $this->mysqli->connect_error;
    exit();
}

if (isset($_GET["submit"])) {
    if ($_GET["firstname"]=="" or $_GET["lastname"]=="") {
        echo "Please enter your firstname, lastname";
    } else {
        $db = DB::getInstance();
        $query1 = "INSERT INTO people (LastName, FirstName, NickName) VALUES(?, ?, ?)";
        $varray1 = array($_GET["lastname"], $_GET["firstname"], $_GET["nickname"]);
        $tarray1 = array("s","s","s");
        $db->do_query($query1, $varray1, $tarray1);
        $id=$db->get_insert_id();

        if ($_GET["phonetype"] != "" and $_GET["phone"] != "") {
            $query2 = "INSERT INTO phonenumbers (PersonID, PhoneType, PhoneNum, AreaCode) VALUES(?, ?, ?, ?)";
            $varray2 = array($id, $_GET["phonetype"], $_GET["phone"], $_GET["areacode"]);
            $tarray2 = array("i","s","s","s");
            $db->do_query($query2, $varray2, $tarray2);
        }

        header("Location: people.php");
        exit();
    }
}

 ?>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Add User</title>
</head>

<body id="home">
	<form method="get" action="adduser.php" id="adduser">
    <table>
      <tr>
        <th>
          First Name:
        </th>
        <th>
          <input name= "firstname" required/>
        </th>
      </tr>
      <tr>
        <th>
          Last Name:
        </th>
        <th>
          <input name= "lastname" required/>
        </th>
      </tr>
      <tr>
        <th>
          Nick Name:
        </th>
        <th>
          <input name= "nickname" />
        </th>
      </tr>
      <tr>
        <th>
          Area Code:
        </th>
        <th>
          <input name= "areacode" />
        </th>
      </tr>
      <tr>
        <th>
          Phone:
        </th>
        <th>
          <input name= "phone" />
        </th>
      </tr>
      <tr>
        <th>
          Type:
        </th>
        <th>
          <select name="phonetype" form="adduser">
            <?php
            $query = "SELECT phonetype FROM phonetype";
            $result = $mysqli->query($query);
            while ($row = $result->fetch_assoc()) {
                $type = $row['phonetype']; ?>
            <option>
              <?= $type ?>
            </option>
            <?php
            }
          ?>
          </select>
        </th>
      </tr>

    </table>

		<input type="submit" name="submit" />
	</form>
</body>
</html>
