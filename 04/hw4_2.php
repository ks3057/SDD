<?php

require_once "hw4_1.php";

$tom = new Person("Holland", "Tom");
$tom->setHeight(68.5);
$tom->setWeight(141);

?>
<link rel="stylesheet" href="../03/css/style.css">
<body>
  <p>
  <?= $tom->calculate_bmi() ?>
  </p>
</body>
