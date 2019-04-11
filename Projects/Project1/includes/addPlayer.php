<?php

if ($_SESSION['role']==1) {
    $players = $db->run("SELECT * FROM server_player")->fetchAll(PDO::FETCH_CLASS, 'Player');
    $teams = $db->getAll('Team', 'server_team');
    $allpositions = $db->getAll('Position', 'server_position');
} elseif ($_SESSION['role']==3 or $_SESSION['role']==4) {
    $players = $db->run(
    "SELECT * FROM server_player WHERE team = ?",
[$_SESSION['team']]
)->fetchAll(PDO::FETCH_CLASS, 'Player');
    $teams = $db->run(
        "SELECT * FROM server_team WHERE id = ?",
  [$_SESSION['team']]
    )->fetchAll(PDO::FETCH_CLASS, 'Team');
    $allpositions = $db->getAll('Position', 'server_position');
} else {
    echo "You are not authorised";
    exit();
}

echo "<label style='color:red'>".$paerror."</label>";
echo "<label style='color:green'>".$pasuccess."</label>";
 ?>
<form method='post' action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" name='addPlayer'>
<?php
echo "<table>";
echo "<tr><td>First Name</td><td>Last Name</td><td>DOB (dd/mm/yyyy)</td><td>Jersey Number</td><td>Team</td><td>Position</td></tr>";
?>
<tr><td><input type="text" name='firstname' value="<?php echo isset($_POST["firstname"]) ? $_POST["firstname"] : ''; ?>" required></td>
<td><input type="text" name='lastname' value="<?php echo isset($_POST["lastname"]) ? $_POST["lastname"] : ''; ?>" required></td>
<td><input type="date" name='dateofbirth' value="<?php echo isset($_POST["dateofbirth"]) ? $_POST["dateofbirth"] : ''; ?>" required></td>
<td><input type="number" name='jerseynumber' value="<?php echo isset($_POST["jerseynumber"]) ? $_POST["jerseynumber"] : ''; ?>" required></td>
<?php
echo "<td><select id = 'team' name='team' required>";
echo "<option selected='' disabled='' value=''>Select Team</option>";
foreach ($teams as $team) {
    $id = $team->__get('id');
    $name = $team->__get('name');
    echo "<option value = $id> $name </option>";
}
echo "</select></td>";
echo "<td><select id = 'position' name='position' required>";
echo "<option selected='' disabled='' value=''>Select Position</option>";
foreach ($allpositions as $allposition) {
    $lid = $allposition->__get('id');
    $lname = $allposition->__get('name');
    echo "<option value = $lid> $lname </option>";
}
echo "</select></td>";

echo "<td><button type='submit' name='addplayer' value='addplayer'>Add Player</button></td>";
echo "</table>";
echo "</form>";
?>
