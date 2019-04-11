<form method='post' action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" name='addSeason'>
<?php
echo "<label style='color:green'>".$seasuccess."</label>";
echo "<label style='color:red'>".$seaerror."</label>";
echo "<table>";
?>
<tr><td><input type="number" name='year' value="<?php echo isset($_POST["year"]) ? $_POST["year"] : ''; ?>" required></td>
  <td><textarea id="description" name="description" required><?php echo $desc; ?></textarea></td>
</tr>
<?php
echo "<tr><td><button type='submit' name='addseason' value='addseason'>Add Season</button></td></tr>";
echo "</table>";
echo "</form>";
?>
