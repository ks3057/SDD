<?php

// include_once
//continues script execution even if file isnt found
// include
require_once "Validator.class.php";

//called automatically by php
function __autoload($class_name)
{   //need to use filename structure (should match exactly)
    require_once "$class_name.class.php";
}
// require

//static class
echo "<h2>Static Function usage</h2>";
$number = 23456;
$yes_no = Validator::numeric($number) ? "is":"is not";
echo "<p>
$number $yes_no a number
</p>";

//the validator class validates numbers in string format as well
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


echo "<h2>Regular Class usage</h2>";
$bob = new Person("Smith", "Bob");
$jones = new Person("Jones");
$person = new Person();

echo "<p>
Bob: " . $bob->sayHello() . "
</p>";
echo "<p>
Mr.Jones: " . $jones->sayHello() . "
</p>";
echo "<p>
TBD Person's last name: " . $person->getLastName() . "
</p>";

?>

<!-- another way to access class in html -->
<p>
  Bob: <?= $bob->sayHello() ?>
</p>

<?php
$tom = new BusinessMajor("Golisano", "Tom");
echo "<p>
Tom: " . $tom->sayHello() . "
</p>";
echo "<p>
His fashion sense: " . $tom->fashion() . "
</p>";


$woz = new ComputerMajor("Wozniak", "Steve");
echo "<p>
Woz: " . $woz->sayHello() . "
</p>";
echo "<p>
His fashion sense: " . $woz->fashion() . "
</p>";
?>
