<?php

require_once "hw4_3.php";

$emilia = new BritishPerson("Clarke", "Emilia");
//height in cm
$emilia->setHeight(157.48);
//weight in kilo
$emilia->setWeight(52);

?>

<link rel="stylesheet" href="../03/css/style.css">
<body>
  <p>
  <?= $emilia->calculate_bmi() ?>
  </p>
</body>
