<script>
function myFunction() {
  alert("I am an alert box!");
}
</script>

<?php
echo "<form method='post' action='' name='viewseason' id='viewseason'>";
echo "<label style='color:red'>".$sverror."</label>";
echo "<label style='color:green'>".$svsuccess."</label>";
echo "<table>";
$seasons = $db->getAll('Season', 'server_season');
echo "<tr><td>Name</td></tr>";
$count = 0;
foreach ($seasons as $season) {
    echo "<tr><td><input type='radio' name='opt' value=".$count.">";
    echo "<input type='hidden' name='id".$count."' value='".$season->__get('id')."'>";
    echo "<input type = 'number' name='year".$count."' value=" .$season->__get('year') ." required></td>";
    echo "<td>";
    echo "<textarea form='viewseason' name='description".$count."'>".$season->__get('description')."</textarea>";
    echo "</td>";
    echo "</tr>"; ?>
    <?php
    $count = $count + 1;
}
echo "</table>";
?>
<button type='submit' name='deleteseason' value='deleteseason' onclick="return confirm('Are you sure?')">Delete Season</button>
<?php
echo "<button type='submit' name='editseason' value='editseason' >Edit Season</button>";
echo "</form>";
