<?php
// $myfile = fopen("13chil.txt", "r") or die("Unable to open file!");
// echo fread($myfile, filesize("13chil.txt"));
// echo fgets($myfile);
// fclose($myfile);

$myfile = fopen("filewrite.txt", "w") or die("Unable to open file!");
$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = "Jane Doe\n";
fwrite($myfile, $txt);
fclose($myfile);
