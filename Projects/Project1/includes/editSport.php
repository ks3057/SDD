<?php
if ($_SESSION['role'] != 1) {
    echo "You are not authorised to view this page";
    exit();
}

echo "<form method='post' action='' name='view'>";
echo "<label style='color:red'>".$sperror."</label>";
echo "<label style='color:green'>".$spsuccess."</label>";
echo "<table>";
$sports = $db->getAll('Sport', 'server_sport');
echo "<tr><td></td><td>Name</td></tr>";
$count = 0;
foreach ($sports as $sport) {
    echo "<tr><td><input type='radio' name='opt' value=".$count.">";
    echo "<input type='hidden' name='id".$count."' value='".$sport->__get('id')."'>";
    echo "<td><input name='name".$count."' value=" .$sport->__get('name') ."></td>"; ?>
    <td><button type='submit' name='deletesport' value='deletesport' onclick="return confirm('Are you sure?')">Delete Sport</button></td>
    <?php
    echo "<td><button type='submit' name='editsport' value='editsport' >Edit Sport</button></td></tr>";
    $count = $count + 1;
}
echo "</table>";
echo "</form>";
