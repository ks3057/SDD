<?php
$seasons = $db->getAll('Season', 'server_season');
$leagues = $db->getAll('League', 'server_league');

 ?>

<script type="text/javascript">
  $(document).ready(function(){
      $("#tsport").change(function(){
        var tsid = $("#tsport").val();
        $.ajax({
          url:"classes/data.php",
          method:'post',
          data: 'tsid=' + tsid
        }).done(function(all){
          console.log(all);
          all = JSON.parse(all);
          $('#tleague').empty();
          $('#tseason').empty();
          all.forEach(function(all){
            $('#tleague').append('<option value = '+ all.league + ' >' + all.name + '</option>');
            $('#tseason').append('<option value = '+ all.id + ' >' + all.year + '</option>');
          });
        });
      });
  });
</script>
<?php
echo "<label style='color:red'>".$terror."</label>";
echo "<label style='color:green'>".$tsuccess."</label>";
 ?>
<form method='post' action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" name='addTeam'>
  <table>
    <tr>
      <td>
        Name
      </td>
      <td>
        <input type="text" name="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>" required/>
      </td>
    </tr>
    <tr>
      <td>
        Mascot
      </td>
      <td>
        <input type="text" name="mascot" value="<?php echo isset($_POST["mascot"]) ? $_POST["mascot"] : ''; ?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Sport
      </td>
      <td>
        <select name="tsport" id="tsport" required>
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
              // $sports = $db->run("SELECT * FROM server_sport INNER JOIN server_slseason
              // ON server_sport.ID=server_slseason.sport", [])->fetchAll(PDO::FETCH_CLASS, 'Sport');
              // foreach ($sports as $sport) {
              //     $id = $sport->__get('id');
              //     $name = $sport->__get('name');
              //     echo "<option value=".$id.">".$name."</option>";
              // }
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
         <select name="tleague" id = "tleague" required>
          </select>
       </td>
     </tr>
     <tr>
       <td>
         Year
       </td>
       <td>
         <select name="tseason" id = "tseason" required>
          </select>
       </td>
     </tr>
     <tr>
       <td>
         Home color
       </td>
       <td>
         <input type="text" name="homecolor" value="<?php echo isset($_POST["homecolor"]) ? $_POST["homecolor"] : ''; ?>" required/>
       </td>
     </tr>
     <tr>
       <td>
         Away color
       </td>
       <td>
         <input type="text" name="awaycolor" value="<?php echo isset($_POST["awaycolor"]) ? $_POST["awaycolor"] : ''; ?>" />
       </td>
     </tr>
     <tr>
       <td>
         Max players
       </td>
       <td>
         <input type="number" name="maxplayers" value="<?php echo isset($_POST["maxplayers"]) ? $_POST["maxplayers"] : ''; ?>" />
       </td>
     </tr>
     <tr>
       <td>
         <button type='submit' name='addteam' value='addteam'>Add Team</button>
       </td>
     </tr>
  </table>
</form>
