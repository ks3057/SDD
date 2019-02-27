<?php
  require "DB.class.php";
  require "FN.class.php";


  $db = DB::getInstance();


    $query = "SELECT *
	          FROM people
	          ORDER BY PersonID";
  $db->do_query($query, array(), array());
  $all_array = $db->fetch_all_array();
  $counter = 0;
  for ($i=0, $len=count($all_array); $i<$len; $i++) {
      $counter = $counter + 1;
      //make the ID into links
      $all_array[$i]["PersonID"] = "<a href='editphones.php?PersonId=".$all_array[$i]["PersonID"]."'>".$all_array[$i]["PersonID"]."</a>";
  }

  echo FN::build_table($all_array);


?>
<br />
<!-- add a user to DB -->
<form action="adduser.php">
         <button type="submit">Add User</button>
      </form>
<p><a href="phones.php">go to phones</a></p>
