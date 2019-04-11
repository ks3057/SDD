
<?php
class DB
{
    private $mysqli;

    public function __construct()
    {
        require_once "/home/MAIN/ks3057/Sites/db_conn.php";

        // 1. Open the db connection
        $this->mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

        // 2. check the connection
        if ($this->mysqli->connect_error) {
            echo "connection failed: " . $this->mysqli->connect_error;
            exit();
        }
    }

    public function print_people()
    {
        // 3. send a query
        $query = "SELECT * FROM people";
        $result = $this->mysqli->query($query);

        if ($result && $this->mysqli->affected_rows) {
            while ($row = $result->fetch_assoc()) {
                echo $row["FirstName"] . " " . $row["LastName"] . "<br />";
            }
        } else {
            echo "empty";
        }
    }

    public function get_people()
    {
        $people = [];

        //query ="select * from people join phone on ... where ... order by ..."
        $query = "SELECT * FROM people";
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt-> execute();
            $stmt->store_result();
            $num_rows = $stmt->affected_rows;
            $stmt->bind_result($id, $first, $last, $nick);

            //bound results
            if ($num_rows > 0) {
                while ($stmt->fetch()) {
                    // code...
                    $people[] = array(
                      "id" => $id,
                      "first" => $first,
                      "last" => $last,
                      "nick" => $nick
                  );
                }
            }

            return $people;
        }
    }


    public function insert_person($last, $first, $nick)
    {
        //for DB to recognise strings, put variables in quotes
        $query = "INSERT INTO people (LastName, FirstName, NickName) VALUES(?, ?, ?)";
        if ($stmt = $this->mysqli->prepare($query)) {
            //first param indicates data types, one char per variable
            $stmt->bind_param("sss", $last, $first, $nick);
            $stmt->execute();

            $stmt->store_result();
            $num_rows = $stmt->affected_rows;

            $insert_id = $stmt->insert_id;

            return $insert_id;
        }
        // Values ('$last', '$first', ''$nick')";
    }
}
