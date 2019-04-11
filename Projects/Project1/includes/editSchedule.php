<?php
//display teams according to role
if ($_SESSION['role']==1) {
    $schedules = $db->run("select *, DATE_FORMAT(scheduled, '%Y-%m-%dT%H:%i') AS scheduled from server_schedule", [])->fetchAll(PDO::FETCH_CLASS, 'Schedule');
    $teams = $db->getAll('Team', 'server_team');
} elseif ($_SESSION['role']==2) {
    $schedules = $db->run("select *, DATE_FORMAT(scheduled, '%Y-%m-%dT%H:%i') AS scheduled from server_schedule where league = ?", [$_SESSION['league']])->fetchAll(PDO::FETCH_CLASS, 'Schedule');
    $teams = $db->run("select * from server_team where league = ?", [$_SESSION['league']])->fetchAll(PDO::FETCH_CLASS, 'Team');
} else {
    echo "You are not authorised";
    exit();
}
echo "<label style='color:red'>".$schedverror."</label>";
echo "<label style='color:green'>".$schedvsuccess."</label>";
echo "<form method='post' action='' name='viewschedule'>";
echo "<label style='color:tomato'>Note: Scores, timing & status can be edited. </label>";
echo "<div class='table-responsive'>";
echo "<table class='table table-striped'>";
echo "<thead><tr><th></th><th>Sport</th><th>League</th><th>Season</th><th>Hometeam</th>
<th>Awayteam</th><th>Homescore</th><th>Awayscore</th><th>Completed</th><th>Scheduled</th></thead>";
$count = 0;
foreach ($schedules as $schedule) {
    $league = $db->run('select * from server_league where id = ?', [$schedule->__get('league')])->fetchAll(PDO::FETCH_CLASS, 'League');
    $sport = $db->run('select * from server_sport where id = ?', [$schedule->__get('sport')])->fetchAll(PDO::FETCH_CLASS, 'Sport');
    $season = $db->run('select * from server_season where id = ?', [$schedule->__get('season')])->fetchAll(PDO::FETCH_CLASS, 'Season');
    $hometeam = $db->run('select * from server_team where id = ?', [$schedule->__get('hometeam')])->fetchAll(PDO::FETCH_CLASS, 'Team');
    $awayteam = $db->run('select * from server_team where id = ?', [$schedule->__get('awayteam')])->fetchAll(PDO::FETCH_CLASS, 'Team');
    echo "<input type='hidden' name='id".$count."' value='".$schedule->__get('id')."'>";
    echo "<tr><td><input type='radio' name='opt' value=".$count.">";
    echo "<td><input type='text' value='".$sport[0]->__get('name')."' name='sport".$count."' readonly/></td>";
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
    <input type='text' value='".$hometeam[0]->__get('name')."' name='name".$count."' readonly/>
    </td>
    ";
    echo "
    <td>
    <input type='text' value='".$awayteam[0]->__get('name')."' name='mascot".$count."' readonly/>
    </td>
    ";
    echo "
    <td>
    <input type='number' value='".$schedule->__get('homescore')."' name='homescore".$count."' required/>
    </td>
    ";
    echo "
    <td>
    <input type='number' value='".$schedule->__get('awayscore')."' name='awayscore".$count."' required/>
    </td>
    ";
    echo "
    <td>";
    if ($schedule->__get('completed')==1) {
        echo "<input type='radio' name='completed".$count."' value='true' checked> Yes <br />";
    } else {
        echo "<input type='radio' name='completed".$count."' value='true'> Yes <br />";
    }

    if ($schedule->__get('completed')==0) {
        echo "<input type='radio' name='completed".$count."' value='false' checked> No <br />";
    } else {
        echo "<input type='radio' name='completed".$count."' value='false'> No <br />";
    }
    echo "</td>";
    echo "
    <td>
    <input type='datetime-local' value='".$schedule->__get('scheduled')."' name='scheduled".$count."' min='1600-06-07T00:00' max='2100-06-07T00:00' required/>
    </td></tr>
    ";
    $count = $count + 1;
}

echo "<tr><td></td></tr>";
echo "</tbody>";
echo "</table>";
echo "</div>";
?>
<button type='submit' name='deleteschedule' value='deleteschedule' onclick="return confirm('Are you sure?')">Delete Schedule</button>
<?php
echo "<button type='submit' name='editschedule' value='editschedule' >Edit Schedule</button><br />";
echo "</form>";
