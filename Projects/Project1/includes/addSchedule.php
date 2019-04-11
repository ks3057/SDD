<?php
$seasons = $db->getAll('Season', 'server_season');
$leagues = $db->getAll('League', 'server_league');
if ($_SESSION['role']==1) {
    $teams = $db->getAll('Team', 'server_team');
} else {
    $teams = $db->getDependent('server_team', 'league', $_SESSION['league'], 'Team');
}
 ?>
 <script type="text/javascript">
   $(document).ready(function(){
       $("#ssport").change(function(){
         var ssid = $("#ssport").val();
         $.ajax({
           url:"classes/data.php",
           method:'post',
           data: 'ssid=' + ssid
         }).done(function(all){
           console.log(all);
           all = JSON.parse(all);
           $('#sleague').empty();
           $('#sseason').empty();
           all.forEach(function(all){
             $('#sleague').append('<option value = '+ all.league + ' >' + all.name + '</option>');
             $('#sseason').append('<option value = '+ all.id + ' >' + all.year + '</option>');
           });
         });
       });
   });
 </script>
 <?php
 echo "<label style='color:red'>".$schedverror."</label>";
 echo "<label style='color:green'>".$schedvsuccess."</label>";
  ?>
  <form method='post' action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" name='addSchedule'>
    <table>
      <tr>
        <td>
          Sport
        </td>
        <td>
          <select name="ssport" id="ssport" required>
            <option selected='' disabled='' value="">Select Sport</option>
            <?php
            if ($_SESSION['role']==1) {
                $slseasons = $db->run("SELECT DISTINCT sport from server_slseason")->
              fetchAll(PDO::FETCH_CLASS, 'SLSeason');
                foreach ($slseasons as $slseason) {
                    $data = $db->run("SELECT * from server_sport where id = ?", [$slseason->__get('sport')])->
              fetchAll(PDO::FETCH_CLASS, 'Sport');
                    echo "<option value=".$data[0]->__get('id').">".$data[0]->__get('name')."</option>";
                }
            } else {
                $slseasons = $db->run("SELECT DISTINCT sport from server_slseason where league = (?)", [$_SESSION['league']])->
                fetchAll(PDO::FETCH_CLASS, 'SLSeason');
                foreach ($slseasons as $slseason) {
                    $data = $db->run("SELECT * from server_sport where id = ?", [$slseason->__get('sport')])->
                fetchAll(PDO::FETCH_CLASS, 'Sport');
                    echo "<option value=".$data[0]->__get('id').">".$data[0]->__get('name')."</option>";
                }
            }
             ?>
           </select>
         </td>
       </tr>
       <tr>
         <td>
           League
         </td>
         <td>
           <select name="sleague" id = "sleague" required>
            </select>
         </td>
       </tr>
       <tr>
         <td>
           Year
         </td>
         <td>
           <select name="sseason" id = "sseason" required>
            </select>
         </td>
       </tr>
       <tr>
         <td>
           HomeTeam
         </td>
         <td>
           <select name="hometeam" id = "hometeam" required>
             <?php
             echo "<option selected='' disabled=''>Select HomeTeam</option>";
               foreach ($teams as $team) {
                   echo "<option value=".$team->__get('id').">".$team->__get('name')."</option>";
               }
              ?>
            </select>
         </td>
       </tr>
       <tr>
         <td>
           AwayTeam
         </td>
         <td>
           <select name="awayteam" id = "awayteam" required>
             <?php
             echo "<option selected='' disabled=''>Select AwayTeam</option>";
               foreach ($teams as $team) {
                   echo "<option value=".$team->__get('id').">".$team->__get('name')."</option>";
               }
              ?>
            </select>
         </td>
       </tr>
       <tr>
         <td>
           HomeScore
         </td>
         <td>
           <input type="number" name="homescore" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>" required/>
         </td>
       </tr>
       <tr>
         <tr>
           <td>
             AwayScore
           </td>
           <td>
             <input type="number" name="awayscore" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>" required/>
           </td>
         </tr>
         <tr>
         <tr>
           <td>
             Scheduled
           </td>
           <td>
             <input type="datetime-local" name="scheduled" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>" required/>
           </td>
         </tr>
         <tr>
           <tr>
             <td>
               Completed
             </td>
             <td>
               <input type='radio' name='completed' value=1 required> Yes
               <input type='radio' name='completed' value=0> No <br />
             </td>
           </tr>
           <tr>
           <tr>
             <td>
               <button type='submit' name='addschedule' value='addschedule'>Add Schedule</button>
             </td>
           </tr>
    </table>
  </form>
