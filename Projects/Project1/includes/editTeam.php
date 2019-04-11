<?php
//display teams according to role
if ($_SESSION['role']==1) {
    $teams = $db->getAll('Team', 'server_team');
} elseif ($_SESSION['role']==2) {
    $teams = $db->run("select * from server_team where league = ?", [$_SESSION['league']])->fetchAll(PDO::FETCH_CLASS, 'Team');
} else {
    echo "You are not authorised";
    exit();
}
echo "<label style='color:red'>".$teamuerror."</label>";
echo "<label style='color:green'>".$teamusuccess."</label>";
echo "<form method='post' action='' name='viewteam'>";
echo "<label style='color:tomato'>Note: Season/League/Sport cannot be edited. </label>";
echo "<label style='color:tomato'>Please delete the team and add again with new combination.</label>";
echo "<table>";
echo "<thead><tr><th></th><th>Name</th><th>Mascot</th><th>Sport</th><th>League</th><th>Year</th>
<th>Homecolor</th><th>AwayColor</th><th>MaxPlayers</th></thead>";
$count = 0;
foreach ($teams as $team) {
    $league = $db->run('select * from server_league where id = ?', [$team->__get('league')])->fetchAll(PDO::FETCH_CLASS, 'League');
    $sport = $db->run('select * from server_sport where id = ?', [$team->__get('sport')])->fetchAll(PDO::FETCH_CLASS, 'Sport');
    $season = $db->run('select * from server_season where id = ?', [$team->__get('season')])->fetchAll(PDO::FETCH_CLASS, 'Season');
    echo "<tr><td><input type='radio' name='opt' value=".$count."></td>";
    echo "<input type='hidden' name='id".$count."' value='".$team->__get('id')."'>";
    echo "
    <td>
    <input type='text' value='".$team->__get('name')."' name='name".$count."' required/>
    </td>
    ";
    echo "
    <td>
    <input type='text' value='".$team->__get('mascot')."' name='mascot".$count."' required/>
    </td>
    ";
    echo "
    <td>
    <input type='text' value='".$sport[0]->__get('name')."' name='sport".$count."' readonly/>
    </td>
    ";
    echo "
    <td>
    <input type='text' value='".$league[0]->__get('name')."' name='league".$count."' readonly/>
    </td>
    ";
    echo "
    <td>
    <input type='text' value='".$season[0]->__get('year')."' name='season".$count."' readonly/>
    </td>
    ";
    echo "
    <td>
    <input type='text' value='".$team->__get('homecolor')."' name='homecolor".$count."' required/>
    </td>
    ";
    echo "
    <td>
    <input type='text' value='".$team->__get('awaycolor')."' name='awaycolor".$count."' />
    </td>
    ";
    echo "
    <td>
    <input type='text' value='".$team->__get('maxplayers')."' name='maxplayers".$count."' />
    </td></tr>
    ";
    echo "
    <tr>
    <td>
    </td>
    <td>
    <a href='includes/addPicture.php?tid=".$team->__get('id')."'>Change Picture</a>
    </td>
    </tr>
    ";
    $count = $count + 1;
}

echo "<tr><td></td></tr>";
echo "</tbody>";
echo "</table>";
echo "<button type='submit' name='deleteteam' value='deleteteam' >Delete Team</button>";
echo "<button type='submit' name='editteam' value='editteam' >Edit Team</button><br />";
echo "<button type='submit' name='deletepicture' value='deletepicture' >Delete Picture</button><br />";
echo "</form>";
