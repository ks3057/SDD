<?php
//This page displays admin forms according to user roles
session_start();
$error = $slerror = $terror = $spoerror = $sposuccess = $seaerror = $seasuccess = $successmessage = $slsuccess = $tsuccess = "";
$uverror = $uvsuccess = $svsuccess= $sverror = $sperror = $spsuccess = $teamuerror = $teamusuccess = $pverror = $pvsuccess = "";
$paerror = $pasuccess = $possuccess = $poserror = $slverror = $slvsuccess = $schedverror = $schedvsuccess ="";
$desc = "";
require_once "classes/DB.class.php";
require_once "classes/Validator.class.php";
$db = new DB();
$vd = new Validator();

include "includes/submissioncheck.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome</title>
  <html>
  <head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#role').change(function(){
      selection = $(this).val();
       switch(selection)
       {
           case '1':
               $('#league').hide();
               $('#teams').hide();
               break;
           case '2':
              $('#league').show();
               $('#teams').hide();
               break;
           default:
               $('#league').show();
               $('#teams').show();
               break;
       }
      });
      });
    </script>
		<script>
					$(document).ready(function() {
			    if (location.hash) {
			        $("a[href='" + location.hash + "']").tab("show");
			    }
			    $(document.body).on("click", "a[data-toggle]", function(event) {
			        location.hash = this.getAttribute("href");
			    });
			});
			$(window).on("popstate", function() {
			    var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
			    $("a[href='" + anchor + "']").tab("show");
			});
		</script>
</head>
<body>
	<?php
      include "includes/nav.php";
            if ($_SESSION['role']==1) {
                ?>

<div class="container">
  <ul class="nav nav-pills" id="navTab">
    <li class="active"><a data-toggle="pill" href="#home">Add User</a></li>
    <li><a data-toggle="pill" href="#menu1">Edit User</a></li>
    <li><a data-toggle="pill" href="#menu2">Add Sport</a></li>
    <li><a data-toggle="pill" href="#menu3">Edit Sport</a></li>
		<li><a data-toggle="pill" href="#menu4">Add Team</a></li>
    <li><a data-toggle="pill" href="#menu5">Edit Team</a></li>
    <li><a data-toggle="pill" href="#menu6">Add Season</a></li>
		<li><a data-toggle="pill" href="#menu7">Edit Season</a></li>
    <li><a data-toggle="pill" href="#menu8">Add SLSeason</a></li>
    <li><a data-toggle="pill" href="#menu9">Edit SLSeason</a></li>
		<li><a data-toggle="pill" href="#menu10">Add Player</a></li>
    <li><a data-toggle="pill" href="#menu11">Edit Player</a></li>
    <li><a data-toggle="pill" href="#menu12">Positions</a></li>
		<li><a data-toggle="pill" href="#menu13">Add Schedule</a></li>
		<li><a data-toggle="pill" href="#menu14">View Schedule</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>Add User</h3>
			<?php include "includes/addUser.php" ?>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>Edit Player</h3>
			<?php include "includes/editUser.php" ?>
    </div>
		<div id="menu2" class="tab-pane fade">
	      <h3>Add Sport</h3>
				<?php include "includes/addSport.php" ?>
	  </div>
		<div id="menu3" class="tab-pane fade">
		      <h3>Edit Sport</h3>
					<?php include "includes/editSport.php" ?>
		</div>
		<div id="menu4" class="tab-pane fade">
      <h3>Add Team</h3>
			<?php include "includes/addTeam.php" ?>
    </div>
		<div id="menu5" class="tab-pane fade">
      <h3>Edit Team</h3>
			<?php include "includes/editTeam.php" ?>
    </div>
		<div id="menu6" class="tab-pane fade">
      <h3>Add Season</h3>
			<?php include "includes/addSeason.php" ?>
    </div>
		<div id="menu7" class="tab-pane fade">
      <h3>Edit Season</h3>
			<?php include "includes/editSeason.php" ?>
    </div>
		<div id="menu8" class="tab-pane fade">
      <h3>Add SLSeason</h3>
			<?php include "includes/addSLSeason.php" ?>
    </div>
		<div id="menu9" class="tab-pane fade">
      <h3>Edit SLSeason</h3>
			<?php include "includes/editSLSeason.php" ?>
    </div>
		<div id="menu10" class="tab-pane fade">
      <h3>Add Player</h3>
			<?php include "includes/addPlayer.php" ?>
    </div>
		<div id="menu11" class="tab-pane fade">
      <h3>Edit Player</h3>
			<?php include "includes/editPlayers.php" ?>
    </div>
		<div id="menu12" class="tab-pane fade">
      <h3>Positions</h3>
			<?php include "includes/positions.php" ?>
    </div>
		<div id="menu13" class="tab-pane fade">
      <h3>Add Schedule</h3>
			<?php include "includes/addSchedule.php" ?>
    </div>
		<div id="menu14" class="tab-pane fade">
      <h3>View Schedule</h3>
			<?php include "includes/editSchedule.php" ?>
    </div>
  </div>
</div>
<?php
            } elseif ($_SESSION['role']==2) {
                ?>

<div class="container">
	<ul class="nav nav-pills" id="navTab">
		<li class="active"><a data-toggle="pill" href="#home">Add User</a></li>
		<li><a data-toggle="pill" href="#menu1">Edit User</a></li>
	 	<li><a data-toggle="pill" href="#menu2">Add Team</a></li>
		<li><a data-toggle="pill" href="#menu3">Edit Team</a></li>
		<li><a data-toggle="pill" href="#menu4">Add Season</a></li>
	 	<li><a data-toggle="pill" href="#menu5">Edit Season</a></li>
		<li><a data-toggle="pill" href="#menu6">Add SLSeason</a></li>
		<li><a data-toggle="pill" href="#menu7">Edit SLSeason</a></li>
	 	<li><a data-toggle="pill" href="#menu8">Add Schedule</a></li>
	 	<li><a data-toggle="pill" href="#menu9">View Schedule</a></li>
	</ul>

	<div class="tab-content">
		<div id="home" class="tab-pane fade in active">
			<h3>Add User</h3>
		 <?php include "includes/addUser.php" ?>
		</div>
		<div id="menu1" class="tab-pane fade">
			<h3>Edit User</h3>
		 <?php include "includes/editUser.php" ?>
		</div>
	 <div id="menu2" class="tab-pane fade">
			<h3>Add Team</h3>
		 <?php include "includes/addTeam.php" ?>
		</div>
	 <div id="menu3" class="tab-pane fade">
			<h3>Edit Team</h3>
		 <?php include "includes/editTeam.php" ?>
		</div>
	 <div id="menu4" class="tab-pane fade">
			<h3>Add Season</h3>
		 <?php include "includes/addSeason.php" ?>
		</div>
	 <div id="menu5" class="tab-pane fade">
			<h3>Edit Season</h3>
		 <?php include "includes/editSeason.php" ?>
		</div>
	 <div id="menu6" class="tab-pane fade">
			<h3>Add SLSeason</h3>
		 <?php include "includes/addSLSeason.php" ?>
		</div>
	 <div id="menu7" class="tab-pane fade">
			<h3>Edit SLSeason</h3>
		 <?php include "includes/editSLSeason.php" ?>
		</div>
	 <div id="menu8" class="tab-pane fade">
			<h3>Add Schedule</h3>
		 <?php include "includes/addSchedule.php" ?>
		</div>
	 <div id="menu9" class="tab-pane fade">
			<h3>View Schedule</h3>
		 <?php include "includes/editSchedule.php" ?>
		</div>
	</div>
</div>
<?php
            } elseif ($_SESSION['role']==3 or $_SESSION['role']==4) {
                ?>

<div class="container">
	<ul class="nav nav-pills" id="navTab">
		<li class="active"><a data-toggle="pill" href="#home">Add User</a></li>
		<li><a data-toggle="pill" href="#menu1">Edit User</a></li>
		<li><a data-toggle="pill" href="#menu2">Add Player</a></li>
    <li><a data-toggle="pill" href="#menu3">Edit Player</a></li>
    <li><a data-toggle="pill" href="#menu4">Positions</a></li>
	</ul>

	<div class="tab-content">
		<div id="home" class="tab-pane fade in active">
			<h3>Add User</h3>
		 <?php include "includes/addUser.php" ?>
		</div>
		<div id="menu1" class="tab-pane fade">
			<h3>Edit User</h3>
		 <?php include "includes/editUser.php" ?>
		</div>
	 <div id="menu2" class="tab-pane fade">
			<h3>Add Player</h3>
		 <?php include "includes/addPlayer.php" ?>
		</div>
	 <div id="menu3" class="tab-pane fade">
			<h3>Edit Player</h3>
		 <?php include "includes/editPlayers.php" ?>
		</div>
	 <div id="menu4" class="tab-pane fade">
			<h3>Positions</h3>
		 <?php include "includes/positions.php" ?>
		</div>
	</div>
</div>
<?php
            } else {
                echo "You are not authorised";
                exit();
            }?>
</body>

</html>
