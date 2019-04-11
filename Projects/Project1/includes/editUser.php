<?php
//display users according to role
echo "<label style='color:red'>".$uverror."</label>";
echo "<label style='color:green'>".$uvsuccess."</label>";
echo "<form method='post' action='' name='viewuser'>";
echo "<label style='color:tomato'>Note: Role cannot be edited. To edit role, please delete user and add them with new role.</label>";
echo "<table>";

if ($_SESSION['role']==1) {
    $users = $db->run("SELECT * FROM server_user ORDER BY role ASC")->fetchAll(PDO::FETCH_CLASS, 'User');
    $roles = $db->getAll('Role', 'server_roles');
    $leagues = $db->getAll('League', 'server_league');
    $teams = $db->getAll('Team', 'server_team');
} elseif ($_SESSION['role']==2) {
    $users = $db->run(
    "SELECT * FROM server_user WHERE (role BETWEEN ? AND ?) AND league = ?",
[3, 4, $_SESSION['league']]
)->fetchAll(PDO::FETCH_CLASS, 'User');
    $roles = $db->run(
        "SELECT * FROM server_roles WHERE id BETWEEN ? AND ?",
  [3, 4]
    )->fetchAll(PDO::FETCH_CLASS, 'Role');
    $leagues = $db->run(
        "SELECT * FROM server_league WHERE id = ?",
  [$_SESSION['league']]
    )->fetchAll(PDO::FETCH_CLASS, 'League');
    $teams = $db->run(
        "SELECT * FROM server_team WHERE league = ?",
  [$_SESSION['league']]
    )->fetchAll(PDO::FETCH_CLASS, 'Team');
} elseif ($_SESSION['role']==3 or $_SESSION['role']==4) {
    $users = $db->run(
  "SELECT * FROM server_user WHERE (role BETWEEN ? AND ?) AND team = ?",
[3, 5, $_SESSION['team']]
)->fetchAll(PDO::FETCH_CLASS, 'User');
    $roles = $db->run(
      "SELECT * FROM server_roles WHERE id BETWEEN ? AND ?",
[3, 5]
  )->fetchAll(PDO::FETCH_CLASS, 'Role');
    $leagues = $db->run(
      "SELECT * FROM server_league WHERE id = ?",
[$_SESSION['league']]
  )->fetchAll(PDO::FETCH_CLASS, 'League');
    $teams = $db->run(
      "SELECT * FROM server_team WHERE id = ?",
[$_SESSION['team']]
  )->fetchAll(PDO::FETCH_CLASS, 'Team');
} else {
    echo "You are not authorised";
    exit();
}

echo "<thead><tr><th></th><th scope='col'>Username</th><th scope='col'>Role</th><th scope='col'>League</th>
<th scope='col'>Team</th></thead>";
$count = 0;
foreach ($users as $user) {
    $uname= $user->__get('username');
    if ($uname != $_SESSION['username']) {
        echo "<tbody>";
        echo "<tr><td><input type='radio' name='opt' value=".$count."></td>";
        echo "<input type='hidden' name='id".$count."' value='".$uname."'>";
        // echo "<tr><td><input type='radio' name='opt".$count."' value=".$uname."></td>";
        echo "<td><input id = 'username' name='username".$count."' value=".$uname." required></td>";
        foreach ($roles as $role) {
            $rid = $role->__get('id');
            $rname = $role->__get('name');
            if ($user->__get('role') == $rid) {
                echo "<td>
              <input type = 'text' readonly name = 'role".$count."' value = '".$rname."'/>
              <input type='hidden' name = 'roleid".$count."' value='".$rid."'>
              </td>";
            }
        }

        // $leagues = $db->getAll('League', 'server_league');
        echo "<td><select id = 'uleague' name='league".$count."'>";
        if (empty($user->__get('league'))) {
            echo "<option selected='' disabled=''>NA</option> ";
        } else {
            foreach ($leagues as $league) {
                $leid = $league->__get('id');
                $lename = $league->__get('name');
                if ($user->__get('league') == $leid) {
                    echo "<option selected='selected' value = $leid> $lename </option>";
                } else {
                    echo "<option value = $leid> $lename </option>";
                }
            }
        }

        echo "<td><select id = 'uteam' name='team".$count."'>";
        if (empty($user->__get('team'))) {
            echo "<option selected='' disabled=''>NA</option> ";
        } else {
            foreach ($teams as $team) {
                $teid = $team->__get('id');
                $tename = $team->__get('name');
                if ($user->__get('team') == $teid) {
                    echo "<option selected='selected' value = $teid> $tename </option>";
                } else {
                    echo "<option value = $teid> $tename </option>";
                }
            }
        }

        echo "</select></td>";
        echo "</tr>";
        $count = $count + 1;
    }
}
echo "<tr><td></td></tr>";
echo "</tbody>";
echo "</table>";
echo "<button type='submit' name='deleteuser' value='deleteuser' >Delete User</button>";
echo "<button type='submit' name='edituser' value='edituser' >Edit User</button><br />";
echo "</form>";
