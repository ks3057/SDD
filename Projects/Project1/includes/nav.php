<?php

$navItems = array(

        array(
          "link"	=> "admin.php",
          "title"	=> "Admin"
        ),

        array(
          "link"	=> "team.php",
          "title"	=> "Team"
        ),

        array(
          "link"	=> "schedule.php",
          "title"	=> "Schedule"
        ),

        array(
          "link"	=> "logout.php",
          "title"	=> "Log Out"
        ),
      ); ?>


    <!-- <ul id="menu"> -->

    <!-- </ul>
  </div>
</nav> -->

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">HeadStart</a>
    </div>
    <ul class="nav navbar-nav">
      <!-- <li class="active"><a href="#">Home</a></li> -->
      <?php
            foreach ($navItems as $item) {
                echo "<li><a href=\"$item[link]\">$item[title]</a></li>";
            }
        ?>
      <!-- <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
      <li><a href="#">Page 3</a></li> -->
    </ul>
  </div>
</nav>
