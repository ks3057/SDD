<form method='post' action='' name='viewslseason'>
<?php
if ($_SESSION['role']==1) {
    $slseasons = $db->getAll('SLSeason', 'server_slseason');
    $sports = $db->getAll('Sport', 'server_sport');
    $seasons = $db->getAll('Season', 'server_season');
    $leagues = $db->getAll('League', 'server_league');
} elseif ($_SESSION['role']==2) {
    $leagues = $db->getDependent('server_league', 'id', $_SESSION['league'], 'League');
    $leagueid = $leagues[0]->__get('id');
    $slseasons = $db->getDependent('server_slseason', 'league', $leagueid, 'SLSeason');
    $sports = $db->getAll('Sport', 'server_sport');
    $seasons = $db->getAll('Season', 'server_season');
} else {
    echo "You are not authorised";
    exit();
}
echo "<label style='color:red'>".$slverror."</label>";
echo "<label style='color:green'>".$slvsuccess."</label>";
echo "<table>";
echo "<tr><td>Sport</td><td>League</td><td>Season</td></tr>";
$count = 0;
foreach ($slseasons as $slseason) {
    $pkey = "";
    echo "<tr><td><input type='radio' name='opt' value=".$count.">";
    echo "<input type='hidden' name='id".$count."' value='".$slseason->__get('id')."'>";
    echo "<select name='sport".$count."'>";
    foreach ($sports as $sport) {
        $id = $sport->__get('id');
        $name = $sport->__get('name');
        if ($slseason->__get('sport') == $id) {
            $pkey .=$id;
            echo "<option selected='selected' value = $id> $name </option>";
        } else {
            echo "<option value = $id> $name </option>";
        }
    }
    echo "</td>";
    echo "<td><select name='league".$count."'>";
    foreach ($leagues as $league) {
        $id = $league->__get('id');
        $name = $league->__get('name');
        if ($slseason->__get('league') == $id) {
            $pkey .=" ".$id;
            echo "<option selected='selected' value = $id> $name </option>";
        } else {
            echo "<option value = $id> $name </option>";
        }
    }
    echo "</td>";
    echo "<td><select name='season".$count."'>";
    foreach ($seasons as $season) {
        $id = $season->__get('id');
        $year = $season->__get('year');
        $desc = $season->__get('description');
        if ($slseason->__get('season') == $id) {
            $pkey .=" ".$id;
            echo "<option selected='selected' value = $id> $year $desc </option>";
        } else {
            echo "<option value = $id> $year $desc </option>";
        }
    }
    echo "<input type='hidden' name='pkey".$count."' value='".$pkey."'>";
    echo "</select></td></tr>";
    $count = $count + 1;
}
echo "</table>";
?>
<button type='submit' name='deleteslseason' value='deleteslseason' onclick="return confirm('Are you sure?')">Delete Combination</button>
<?php
echo "<button type='submit' name='editslseason' value='editslseason' >Edit Combination</button>";
echo "</form>";
