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
  echo FN::build_table($db->fetch_all_array());
