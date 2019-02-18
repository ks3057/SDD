<?php

require_once "DB.class.php";

$db = new DB();
// $db->print_people();

$arr = $db->get_people();

print_r($arr);



// $id = $db->insert_person("Brown", "Charlie", "Chuck");
// echo "You inserted a record with ID: $id <br/>";
