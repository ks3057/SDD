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
session_start();
require_once "classes/DB.class.php";
$db = new DB();
$path = "teampictures/";

if ($_SESSION['role'] == 2) {
    $allpositions = $db->getAll('Position', 'server_position');
    $teams = $db->getDependent('server_team', 'league', $_SESSION["league"], 'Team');
} elseif ($_SESSION['role'] > 2 and $_SESSION['role'] < 6) {
    $allpositions = $db->getAll('Position', 'server_position');
    $teams = $db->getDependent('server_team', 'id', $_SESSION["team"], 'Team');
} else {
    $allpositions = $db->getAll('Position', 'server_position');
    $teams = $db->getAll('Team', 'server_team');
}
foreach ($teams as $team) {
    echo "<br />";
    echo "<h2>Team: ".$team->__get('name').'</h2>';
    echo "<br />";
    if ($team->__get('picture') != null) {
        $image = $path.$team->__get('picture');
        echo '<img src="'.$image.'" alt="team picture" height="200"/>';
    }
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>FirstName</th><th>Lastname</th><th>DOB (YYYY-MM-DD)</th>
  <th>Jersey Number</th><th>Position</th></thead>";
    $players = $db->getDependent('server_player', 'team', $team->__get('id'), 'Player');
    foreach ($players as $player) {
        $playerpos = $db->run('select * from server_playerpos where player = ? ', [$player->__get('id')])->fetchAll(PDO::FETCH_CLASS, 'Playerpos');
        echo "
    <td>
    <label>".$player->__get('firstname')."</label>
    </td>
    ";
        echo "
    <td>
    <label>".$player->__get('lastname')."</label>
    </td>
    ";
        echo "
    <td>
    <label>".$player->__get('dateofbirth')."</label>
    </td>
    ";
        echo "
    <td>
    <label>".$player->__get('jerseynumber')."</label>
    </td>
    ";

        echo "<td><label>";
        foreach ($allpositions as $allposition) {
            $id = $allposition->__get('id');
            $name = $allposition->__get('name');
            if ($playerpos[0]->__get('position')==$id) {
                echo $name;
            }
        }
        echo "</label></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "<hr />";
}
?>
</div>
</body>

</html>
