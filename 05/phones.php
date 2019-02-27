<?php
  require "DB.class.php";
  require "FN.class.php";


  $db = DB::getInstance();


    $query = "SELECT *
	          FROM people
	          JOIN phonenumbers
	            ON phonenumbers.PersonID = people.PersonID
	          ORDER BY phonenumbers.PersonID, PhoneType";
  $db->do_query($query, array(), array());
  $all_array = $db->fetch_all_array();
  $counter = 0;
  for ($i=0, $len=count($all_array); $i<$len; $i++) {
      $counter = $counter + 1;
      $all_array[$i]["link"] = "<a href='addphone.php?PersonID=".$all_array[$i]["PersonID"]."'>Add Phone</a>";
  }

  echo FN::build_table($all_array);
