<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Team</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body id="home">
  <?php include "includes/nav.php"; ?>
<div class="container">
<?php
//display teams according to role
session_start();
require_once "classes/DB.class.php";
$db = new DB();
if ($_SESSION['role']==1) {
    $schedules = $db->run("select *, DATE_FORMAT(scheduled, '%Y-%m-%dT%H:%i') AS scheduled from server_schedule", [])->fetchAll(PDO::FETCH_CLASS, 'Schedule');
    $teams = $db->getAll('Team', 'server_team');
} elseif ($_SESSION['role']==2) {
    $schedules = $db->run("select *, DATE_FORMAT(scheduled, '%Y-%m-%dT%H:%i') AS scheduled from server_schedule where league = ?", [$_SESSION['league']])->fetchAll(PDO::FETCH_CLASS, 'Schedule');
    $teams = $db->run("select * from server_team where league = ?", [$_SESSION['league']])->fetchAll(PDO::FETCH_CLASS, 'Team');
} else {
    $schedules = $db->run("select *, DATE_FORMAT(scheduled, '%Y-%m-%dT%H:%i') AS scheduled from server_schedule where hometeam = ? or awayteam = ?", [$_SESSION['team'], $_SESSION['team']])->fetchAll(PDO::FETCH_CLASS, 'Schedule');
    $teams = $db->run("select * from server_team where league = ?", [$_SESSION['league']])->fetchAll(PDO::FETCH_CLASS, 'Team');
}


echo "<div class='table-responsive'>";
echo "<table class='table table-striped'>";
echo "<thead><tr><th>Sport</th><th>League</th><th>Season</th><th>Hometeam</th>
<th>Awayteam</th><th>Homescore</th><th>Awayscore</th><th>Completed</th><th>Scheduled</th></thead>";
$count = 0;
foreach ($schedules as $schedule) {
    $league = $db->run('select * from server_league where id = ?', [$schedule->__get('league')])->fetchAll(PDO::FETCH_CLASS, 'League');
    $sport = $db->run('select * from server_sport where id = ?', [$schedule->__get('sport')])->fetchAll(PDO::FETCH_CLASS, 'Sport');
    $season = $db->run('select * from server_season where id = ?', [$schedule->__get('season')])->fetchAll(PDO::FETCH_CLASS, 'Season');
    $hometeam = $db->run('select * from server_team where id = ?', [$schedule->__get('hometeam')])->fetchAll(PDO::FETCH_CLASS, 'Team');
    $awayteam = $db->run('select * from server_team where id = ?', [$schedule->__get('awayteam')])->fetchAll(PDO::FETCH_CLASS, 'Team');

    echo "<tr>";
    echo "<td><label>".$sport[0]->__get('name')."</label></td>";
    echo "
    <td>
    <label>".$league[0]->__get('name')."</label>
    </td>
    ";
    echo "
    <td>
    <label>".$season[0]->__get('year')."</label>
    </td>
    ";
    echo "
    <td>
    <label>".$hometeam[0]->__get('name')."</label>
    </td>
    ";
    echo "
    <td>
    <label>".$awayteam[0]->__get('name')."</label>
    </td>
    ";
    echo "
    <td>
    <label>".$schedule->__get('homescore')."</label>
    </td>
    ";
    echo "
    <td>
    <label>".$schedule->__get('awayscore')."</label>
    </td>
    ";
    echo "
    <td>";
    if ($schedule->__get('completed')==1) {
        echo "<label>Yes</label>";
    } else {
        echo "<label>No</label>";
    }
    echo "</td>";
    echo "
    <td>
    <label>".$schedule->__get('scheduled')."</label>
    </td></tr>
    ";
    $count = $count + 1;
}

echo "</tbody>";
echo "</table>";
echo "</div>";
?>
