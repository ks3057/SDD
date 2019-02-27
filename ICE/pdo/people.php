<?php
require_once "DB.class.php";

$db = new DB();
$data = $db->getPeopleFirstName("priyanka");
foreach ($data as $row) {
    echo "<pre>";
    print_r($row);
    echo "</pre>";
};


$data = $db->getPeopleParameterized(1);

foreach ($data as $row) {
    echo "<pre>";
    print_r($row);
    echo "</pre>";
};


$lastId = $db ->insert("Bush", "Vannevar", "Van");
echo "last id inserted: " .$lastId;

$people = $db->getAllObjects();
foreach ($people as $person) {
    echo "<p>
  {$person->whoami()}
  </p>";
}
