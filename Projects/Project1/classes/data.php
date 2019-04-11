<?php
//a helper page for scripts used throughout the website. It encodes DB rows into json.
session_start();
require "DB.class.php";
$db = new DB();

if (isset($_POST['lid'])) {
    if ($_SESSION['role'] == 3 or $_SESSION['role'] == 4) {
        $teams = $db->run(
    "SELECT * FROM server_team WHERE id = ?",
        [$_SESSION['team']]
    )->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($teams);
    } else {
        $teams = $db->run(
    "SELECT * FROM server_team WHERE league = ?",
        [$_POST['lid']]
    )->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($teams);
    }
}

if (isset($_POST['tsid'])) {
    $all = $db->run(
      "SELECT s.id,s.year,sl.league,l.name FROM server_slseason sl join server_league l on l.id = sl.league
      join server_season s on s.id = sl.season
      where sl.sport = ?",
        [$_POST['tsid']]
    )->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($all);
}

if (isset($_POST['ssid'])) {
    $all = $db->run(
      "SELECT s.id,s.year,sl.league,l.name FROM server_slseason sl join server_league l on l.id = sl.league
      join server_season s on s.id = sl.season
      where sl.sport = ?",
        [$_POST['ssid']]
    )->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($all);
}




if (isset($_POST['tlid'])) {
    $seasons = $db->run(
      "SELECT * from server_season where league = ? ",
    [$_POST['tlid']]
    )->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($seasons);
}
