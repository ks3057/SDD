<?php

if ($_SESSION['role']==1) {
    $roles = $db->getAll('Role', 'server_roles');
    $leagues = $db->getAll('League', 'server_league');
} elseif ($_SESSION['role']==2) {
    $roles = $db->run(
        "SELECT * FROM server_roles WHERE id BETWEEN ? AND ?",
  [3, 4]
    )->fetchAll(PDO::FETCH_CLASS, 'Role');
    $leagues = $db->run(
        "SELECT * FROM server_league WHERE id = ?",
  [$_SESSION['league']]
    )->fetchAll(PDO::FETCH_CLASS, 'League');
} elseif ($_SESSION['role']== 3 or $_SESSION['role']== 4) {
    $roles = $db->run(
      "SELECT * FROM server_roles WHERE id BETWEEN ? AND ?",
[3, 5]
  )->fetchAll(PDO::FETCH_CLASS, 'Role');
    $leagues = $db->run(
      "SELECT * FROM server_league WHERE id = ?",
[$_SESSION['league']]
  )->fetchAll(PDO::FETCH_CLASS, 'League');
} else {
    echo "You are not authorised";
    exit();
}


 ?>
<script type="text/javascript">
  $(document).ready(function(){
      $("#league").change(function(){
        var lid = $("#league").val();
        $.ajax({
          url:"classes/data.php",
          method:'post',
          data: 'lid=' + lid
        }).done(function(teams){
          console.log(teams);
          teams = JSON.parse(teams);
          $('#teams').empty();
          teams.forEach(function(team){
            $('#teams').append('<option value = '+ team.id + ' >' + team.name + '</option>');
          });
        });
      });
  });
</script>
<?php
echo "<label style='color:red'>".$error."</label>";
echo "<label style='color:green'>".$successmessage."</label>";
 ?>
<form method='post' action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" name='addUser'>
<?php
echo "<table>";
echo "<tr><td>Username</td><td>Role</td><td>League</td><td>Team</td></tr>";
?>
<tr><td><input name='username' value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ''; ?>" required></td>
<?php
echo "<td><select id = 'role' name='role' required>";
echo "<option selected='' disabled='' value=''>Select Role</option>";
foreach ($roles as $role) {
    $id = $role->__get('id');
    $name = $role->__get('name');
    echo "<option value = $id> $name </option>";
}
echo "</select></td>";
echo "<td><select id = 'league' name='league'>";
echo "<option selected='' disabled=''>Select League</option>";
foreach ($leagues as $league) {
    $lid = $league->__get('id');
    $lname = $league->__get('name');
    echo "<option value = $lid> $lname </option>";
}
echo "</select></td>";
echo"<td><select id='teams' name='team'>";
echo "</select></td>";
echo "<td><button type='submit' name='adduser' value='adduser'>Add User</button></td>";
echo "</table>";
echo "</form>";
?>
