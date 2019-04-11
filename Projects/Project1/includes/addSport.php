<?php
if ($_SESSION['role'] != 1) {
    echo "You are not authorised to view this page";
    exit();
}

echo "<label style='color:red'>".$spoerror."</label>";
echo "<label style='color:green'>".$sposuccess."</label>";
 ?>
<form method='post' action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" name='addSport'>
<?php
echo "<table>";
echo "<tr><td>Sport Name</td></tr>";
?>
<tr><td><input name='name' value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>"></td>
<?php
echo "<td><button type='submit' name='addsport' value='addsport'>Add Sport</button></td>";
echo "</table>";
echo "</form>";
?>
