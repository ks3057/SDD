
<?php
if ($_SESSION['role']==1) {
    $leagues = $db->getAll('League', 'server_league');
    $sports = $db->getAll('Sport', 'server_sport');
    $seasons = $db->getAll('Season', 'server_season');
} elseif ($_SESSION['role']==2) {
    $leagues = $db->getDependent('server_league', 'id', $_SESSION['league'], 'League');
    $sports = $db->getAll('Sport', 'server_sport');
    $seasons = $db->getAll('Season', 'server_season');
} else {
    echo "You are not authorised";
    exit();
}
    ?>
    <form method='post' action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" name='addSLSeason'>
      <?php
      echo "<label style='color:green'>".$slsuccess."</label>";
      echo "<label style='color:red'>".$slerror."</label>";
      echo "<table>";
       ?>
    <tr>
      <td>
        Sport:
      </td>
      <td>
        <select id="sport" name="sport" required>
          <?php
          echo "<option selected='' disabled=''>Select Sport</option>";
            foreach ($sports as $sport) {
                echo "<option value=".$sport->__get('id').">".$sport->__get('name')."</option>";
            }
           ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        League:
      </td>
      <td>
        <select id="league" name="league" required>
          <?php
          echo "<option selected='' disabled=''>Select League</option>";
          foreach ($leagues as $league) {
              echo "<option value=".$league->__get('id').">".$league->__get('name')."</option>";
          }
           ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        Season:
      </td>
      <td>
        <select id="season" name="season" required>
          <?php
          echo "<option selected='' disabled=''>Select Season</option>";
          foreach ($seasons as $season) {
              echo "<option value=".$season->__get('id').">".$season->__get('year')." ".$season->__get('description')."</option>";
          }
           ?>
        </select>
      </td>
    </tr>

<?php
echo "<tr><td><button type='submit' name='addslseason' value='addslseason'>Add SLSeason</button></td></tr>";
echo "</table>";
echo "</form>";
?>
