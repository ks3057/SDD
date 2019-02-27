<?php
  require "DB.class.php";
  require "FN.class.php";
  require_once "/home/MAIN/ks3057/Sites/db_conn.php";

  $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
  if ($mysqli->connect_error) {
      echo "connection failed: " . $this->mysqli->connect_error;
      exit();
  }

  $db = DB::getInstance();
  $clause="";
  $query = "SELECT *
          FROM phonenumbers";

//if phone number is deleted
  if (isset($_POST["delete"])) {
      $arr_ph = explode("-", $_POST['pid']);
      $queryd = "DELETE FROM phonenumbers WHERE PhoneID = ?";
      $db->do_query($queryd, array( $arr_ph[0] ), array("i"));
      $_GET["PersonId"] = $arr_ph[1];
  }

//if phone number is modified
  if (isset($_POST["modify"])) {
      $queryd = "UPDATE phonenumbers SET PersonID=?, PhoneType=?, PhoneNum=?, AreaCode=? WHERE PhoneID=? ";
      $db->do_query(
        $queryd,
        array( $_POST['personid'], $_POST['phonetype'], $_POST['phonenum'], $_POST['areacode'], $_POST['phoneid']),
    array("i","s","s","s","i")
    );
      $_GET["PersonId"] = $_POST['personid'];
  }

//if user WANTS to edit a phonenumber, display below form
  if (isset($_POST["edit"])) {
      unset($_GET["PersonId"]);
      $arr_ph = explode("-", $_POST['pid']);
      $querym = "SELECT *
              FROM phonenumbers WHERE PhoneID = ? ";
      $db->do_query($querym, array( $arr_ph[0] ), array("i"));
      $result_arr = $db->fetch_all_array(); ?>
      <form method="post" action="editphones.php" id="editphone">
      <table>
        <tr>
          <th>
            Area Code:
          </th>
          <th>
            <input name="areacode" value=<?= $result_arr[0]['AreaCode'] ?> >
          </th>
        </tr>
          <th>
            Phone:
          </th>
          <th>
            <input name="phonenum" value=<?= $result_arr[0]['PhoneNum'] ?> required>
          </th>
        </tr>
        <tr>
          <th>
            Type:
          </th>
          <th>
            <select name="phonetype" form="editphone">
              <?php
              $queryp = "SELECT phonetype FROM phonetype";
      $result = $mysqli->query($queryp);
      while ($row = $result->fetch_assoc()) {
          $type = $row['phonetype'];

          if ($type == $result_arr[0]['PhoneType']) {
              ?>
                    <option selected="selected">

                    <?php
          } else {
              ?>
              <option>
              <?php
          } ?>
                <?= $type ?>
              </option>
              <?php
      } ?>
            </select>
          </th>
        </tr>
        <tr>
          <th>
            Person ID:
          </th>
          <th>
            <input type="number" name="personid" value=<?= $result_arr[0]['PersonID'] ?> required>
          </th>
        </tr>
        <tr>
          <th>
            Phone ID:
          </th>
          <th>
            <input type="number" name="phoneid" value=<?= $result_arr[0]['PhoneID'] ?> readonly>
          </th>
        </tr>
      </table>
      <input type="submit" name="modify" />
      </form>

<?php
  }

//normal page display. when navigated to this page by passing the personid in query string
 if (isset($_GET["PersonId"])) {
     if (isset($_GET["delete"])) {
         echo "delete";
     }
     $id = $_GET['PersonId'];
     $query .= " WHERE PersonID = ? ";
     $query .= " ORDER BY phonenumbers.PersonID, PhoneType";

     $db->do_query($query, array( $id ), array( "s" ));

     $result_arr = $db->fetch_all_array(); ?>
     <form method="post" action= "editphones.php">
      <?php
     if (!empty($result_arr)) {
         for ($i=0, $len=count($result_arr); $i<$len; $i++) {
             $result_arr[$i]["PersonID"] = "<input type='radio' name='pid' value=".$result_arr[$i]['PhoneID']."-".$result_arr[$i]['PersonID'] ."/>".$result_arr[$i]['PersonID'];
         }

         echo FN::build_table($result_arr); ?>

         <button type="submit" name="delete">Delete Phone</button>
         <button type="submit" name="edit">Edit Phone</button>
</form>
<?php
     } else {
         echo "Person does not have any phone associated";
     }
 }
?>
