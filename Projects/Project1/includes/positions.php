<?php
echo "<label>Add Position:</label>";
echo "<br />";
echo "<label style='color:green'>".$possuccess."</label>";
echo "<label style='color:red'>".$poserror."</label>";
?>
<form method='post' action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" name='addPosition'>
<tr><td><input type="text" name='name' value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>" required></td>
</tr>
<?php
echo "<button type='submit' name='addposition' value='addposition'>Add Position</button>";
echo "</form>";
echo "<br />";
echo "<hr />";
echo "<label>Available Positions:</label>";
echo "<br />";
echo "<select>";
$allpositions = $db->getAll('Position', 'server_position');
foreach ($allpositions as $allposition) {
    $id = $allposition->__get('id');
    $name = $allposition->__get('name');
    echo "<option value = $id> $name </option>";
}
echo "</select>";
?>
