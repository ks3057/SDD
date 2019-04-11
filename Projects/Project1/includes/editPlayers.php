<?php
//display users according to role
echo "<label style='color:red'>".$pverror."</label>";
echo "<label style='color:green'>".$pvsuccess."</label>";
echo "<form method='post' action='' name='viewuser'>";
echo "<label style='color:tomato'>Note: Team cannot be edited</label>";
echo "<table>";

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

echo "<thead><tr><th></th><th></th><th>FirstName</th><th>Lastname</th><th>DOB (DD/MM/YYYY)</th>
<th>Jersey Number</th><th>Team</th><th>Position</th></thead>";
$count = 0;
foreach ($players as $player) {
    $team = $db->run('select * from server_team where id = ?', [$player->__get('team')])->fetchAll(PDO::FETCH_CLASS, 'Team');
    $playerpos = $db->run('select * from server_playerpos where player = ? ', [$player->__get('id')])->fetchAll(PDO::FETCH_CLASS, 'Playerpos');
    echo "<tr><td><input type='radio' name='opt' value=".$count."></td>";
    echo "
  <td>
  <input type='hidden' name='id".$count."' value='".$player->__get('id')."'>
  </td>
  ";
    echo "
  <td>
  <input type='text' value='".$player->__get('firstname')."' name='firstname".$count."' required/>
  </td>
  ";
    echo "
  <td>
  <input type='text' value='".$player->__get('lastname')."' name='lastname".$count."' required/>
  </td>
  ";
    echo "
  <td>
  <input type='date' value='".$player->__get('dateofbirth')."' name='dateofbirth".$count."' required/>
  </td>
  ";
    echo "
  <td>
  <input type='number' value='".$player->__get('jerseynumber')."' name='jerseynumber".$count."' required/>
  </td>
  ";
    echo "
  <td>
  <input type='text' value='".$team[0]->__get('name')."' name='team".$count."' readonly/>
  </td>
  ";

    echo "<td><select name='position".$count."' required>";
    foreach ($allpositions as $allposition) {
        $id = $allposition->__get('id');
        $name = $allposition->__get('name');
        if ($playerpos[0]->__get('position')==$id) {
            echo "<option value = $id selected = 'selected'> $name </option>";
        } else {
            echo "<option value = $id> $name </option>";
        }
    }
    echo "</select></td>";
    $count = $count + 1;
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
echo "<button type='submit' name='deleteplayer' value='deleteplayer' >Delete Player</button>";
echo "<button type='submit' name='editplayer' value='editplayer' >Edit Player</button><br />";
echo "</form>";
