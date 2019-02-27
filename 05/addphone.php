<?php

require_once "/home/MAIN/ks3057/Sites/db_conn.php";
$person_id = "";

if (isset($_GET["PersonID"]) and $_GET["PersonID"] != "") {
    $person_id = $_GET["PersonID"];
}
// 1. Open the db connection
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// 2. check the connection
if ($mysqli->connect_error) {
    echo "connection failed: " . $this->mysqli->connect_error;
    exit();
}

//if form submitted, insert values to DB
if (isset($_GET["submit"])) {
    if ($_GET["phonenum"]=="" or $_GET["phonetype"]=="") {
        echo "Please enter phone number, phone type";
    } else {
        $query = "INSERT INTO phonenumbers (PersonID, PhoneType, PhoneNum, AreaCode) VALUES(?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($query)) {
            //first param indicates data types, one char per variable
            $stmt->bind_param("isss", $_GET["personid"], $_GET["phonetype"], $_GET["phonenum"], $_GET["areacode"]);
            $stmt->execute();

            $stmt->store_result();
            $num_rows = $stmt->affected_rows;

            $insert_id = $stmt->insert_id;
        }
        header("Location: phones.php");
        exit();
    }
}

 ?>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Add User</title>
</head>

<!-- the select tag is populated from the DB -->
<body id="home">
	<form method="get" action="addphone.php" id="addphone">
    <table>
      <tr>
        <th>
          Area Code:
        </th>
        <th>
          <input name= "areacode" />
        </th>
      </tr>
        <th>
          Phone:
        </th>
        <th>
          <input name= "phonenum" required/>
        </th>
      </tr>
      <tr>
        <th>
          Type:
        </th>
        <th>
          <select name="phonetype" form="addphone">
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
      <tr>
        <th>
          Person ID:
        </th>
        <th>
          <input type="number" name="personid" value=<?= $person_id ?> required>
        </th>
      </tr>
    </table>
		<input type="submit" name="submit" value="Add Phone"/>
	</form>
  <a href="phones.php">Go back</a>
</body>
</html>
