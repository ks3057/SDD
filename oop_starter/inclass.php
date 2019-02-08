<?php

// include_once
//continues script execution even if file isnt found
// include
require_once "Validator.class.php";
// require

//static class
echo "<h2>Static function usage</h2>";
$number = 23456;
$yes_no = Validator::numeric($number) ? "is":"is not";
echo "<p>
$number $yes_no a number
</p>";

$number = "23456234";
$yes_no = Validator::numeric($number) ? "is":"is not";
echo "<p>
$number $yes_no a number
</p>";

$number = "23456a234";
$yes_no = Validator::numeric($number) ? "is":"is not";
echo "<p>
$number $yes_no a number
</p>";

$number = "one";
$yes_no = Validator::numeric($number) ? "is":"is not";
echo "<p>
$number $yes_no a number
</p>";
