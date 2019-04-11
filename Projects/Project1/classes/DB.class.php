<?php
class DB
{
    private $dbh;
    protected $users_class='';


    /**
     * constructor
     */
    public function __construct()
    {
        require_once("/home/MAIN/ks3057/Sites/db_conn.php");
        define('ROOT_DIR', '/home/MAIN/ks3057/Sites/756/Projects/Project1/');
        function __autoload($class_name)
        {   //need to use filename structure (should match exactly)
            require_once "$class_name.class.php";
        }
        try {
            //open a connection
            $this->dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

            //change error reporting
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $logfile = fopen(ROOT_DIR.'error/error_log.txt', "a") or die("Unable to open file!");
            $txt = $e->getMessage();
            fwrite($logfile, $_SESSION['username']." ".date("M,d,Y h:i:s A") ."\n". $txt ."\n");
            fclose($logfile);
            return false;
        }
    }

    /**
     * returns string representation of object
     * @return string [string representation of object]
     */
    public function __toString()
    {
        return (string)$this->users_class;
    }


    /**
     * Reset password for users
     * @param [boolean] $name [username of password change requester]
     */
    public function resetPassword($name)
    {
        try {
            //object mapping

            $data = array();
            $user = $this->dbh->prepare("UPDATE server_user SET password = :pass WHERE username = :name");
            $pass = password_hash('Passw0rd1', PASSWORD_DEFAULT);
            $result = $user->execute(array('pass'=>$pass, 'name'=>$name ));
            return $result;
        } catch (PDOException $e) {
            $logfile = fopen(ROOT_DIR.'error/error_log.txt', "a") or die("Unable to open file!");
            $txt = $e->getMessage();
            fwrite($logfile, $_SESSION['username']." ".date("M,d,Y h:i:s A") ."\n". $txt ."\n");
            fclose($logfile);
            return false;
        }
    }

    /**
     * Adds picture to DB
     * @param [String] $path [path of pic storage]
     * @param [Integer] $id   [team id]
     */
    public function addPicture($path, $id)
    {
        try {
            //object mapping

            $data = array();
            $user = $this->dbh->prepare("UPDATE server_team SET picture = :picture WHERE id = :id");
            $res = $user->execute(array('picture'=>$path, 'id'=>$id ));
            return $res;
        } catch (PDOException $e) {
            $logfile = fopen(ROOT_DIR.'error/error_log.txt', "a") or die("Unable to open file!");
            $txt = $e->getMessage();
            fwrite($logfile, $_SESSION['username']." ".date("M,d,Y h:i:s A") ."\n". $txt ."\n");
            fclose($logfile);
            return false;
        }
    }

    /**
     * For login usage.
     * @param  [String] $name [name of user logging in]
     * @return [User Object]       [Object with user details]
     */
    public function getUser($name)
    {
        try {
            //object mapping

            include_once "User.class.php";
            $data = array();
            $user = $this->dbh->prepare('SELECT * FROM server_user WHERE username = :name');
            $user->execute(array('name'=>$name));
            return $user->fetchObject('User');
        } catch (PDOException $e) {
            $logfile = fopen(ROOT_DIR.'error/error_log.txt', "a") or die("Unable to open file!");
            $txt = $e->getMessage();
            fwrite($logfile, $_SESSION['username']." ".date("M,d,Y h:i:s A") ."\n". $txt ."\n");
            fclose($logfile);
            return false;
        }
    }

    /**
     * Helper function for data insertion
     * @param  [String] $table [table to insert data in]
     * @param  [Array] $array [The POST array]
     * @return [Boolean]        [True if values inserted]
     */
    public function insert_data($table, $array)
    {
        try {
            switch ($table) {
        case "server_user":
            $pass = password_hash("Passw0rd1", PASSWORD_DEFAULT);
            if ($array['role'] == 1) {
                $sql = $this->dbh->prepare('INSERT INTO server_user (username, role, password)
                VALUES (?, ?, ?)');
                $success = $sql->execute(array($array['username'], $array['role'], $pass));
                return $success;
            } elseif ($array['role'] == 2) {
                $sql = $this->dbh->prepare('INSERT INTO server_user (username, role, password, league)
              VALUES (?, ?, ?, ?)');
                $success = $sql->execute(array($array['username'], $array['role'], $pass, $array['league']));
                return $success;
            } else {
                $sql = $this->dbh->prepare('INSERT INTO server_user (username, role, password, team, league)
              VALUES (?, ?, ?, ?, ?)');
                $success = $sql->execute(array($array['username'], $array['role'], $pass, $array['team'], $array['league']));
                return $success;
            }
            break;

        case "server_sport":
            $sql = $this->dbh->prepare('INSERT INTO server_sport(name)
                VALUES (?)');
            $success = $sql->execute(array($array['name']));
            return $success;
            break;

        case "server_season":

            $sql = $this->dbh->prepare('INSERT INTO server_season (year, description)
                VALUES (?, ?)');
            $success = $sql->execute(array($array['year'],$array['description']));
            return $success;

            break;

        case "server_team":
            $sql = $this->dbh->prepare('INSERT INTO server_team(name, mascot, sport, league, season, homecolor, awaycolor, maxplayers)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $success = $sql->execute(array($array['name'],$array['mascot'], $array['tsport'], $array['tleague'],
                                          $array['tseason'], $array['homecolor'], $array['awaycolor'], $array['maxplayers']));
            return $success;
            break;
          }
        } catch (PDOException $e) {
            $logfile = fopen(ROOT_DIR.'error/error_log.txt', "a") or die("Unable to open file!");
            $txt = $e->getMessage();
            fwrite($logfile, $_SESSION['username']." ".date("M,d,Y h:i:s A") ."\n". $txt ."\n");
            fclose($logfile);
            return false;
        }
    }

    /**
     * Get All objects of a table from DB
     * @param  [String] $class [classname]
     * @param  [String] $table [tablename]
     * @return [Array]        [Objects from DB]
     */
    public function getAll($class, $table)
    {
        try {
            //object mapping
            $data = array();
            $stmt = $this->dbh->prepare("SELECT * FROM $table");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, $class);

            while ($league = $stmt->fetch()) {
                $data[] = $league;
            }

            return $data;
        } catch (PDOException $e) {
            $logfile = fopen(ROOT_DIR.'error/error_log.txt', "a") or die("Unable to open file!");
            $txt = $e->getMessage();
            fwrite($logfile, $_SESSION['username']." ".date("M,d,Y h:i:s A") ."\n". $txt ."\n");
            fclose($logfile);
            return false;
        }
    }

    /**
     * Delete data from table
     * @param  [String] $table [tablename]
     * @param  [String] $var   [columnname]
     * @param  [String] $val   [columnvalue]
     * @return [Boolean]        [True if deleted]
     */
    public function delete_data($table, $var, $val)
    {
        try {
            //object mapping
            $data = array();
            $stmt = $this->dbh->prepare("DELETE FROM $table
                    WHERE $var = ?");
            $stmt->execute([$val]);

            return $stmt;
        } catch (PDOException $e) {
            $logfile = fopen(ROOT_DIR.'error/error_log.txt', "a") or die("Unable to open file!");
            $txt = $e->getMessage();
            fwrite($logfile, $_SESSION['username']." ".date("M,d,Y h:i:s A") ."\n". $txt ."\n");
            fclose($logfile);
            return false;
        }
    }

    /**
     * Get Dependent values (i.e. one where clause in select)
     * @param  [String] $table [tablename]
     * @param  [String] $var   [columnname]
     * @param  [String] $id    [columnvalue]
     * @param  [String] $class [classname]
     * @return [Array]        [Array of objects from DB]
     */
    public function getDependent($table, $var, $id, $class)
    {
        try {
            //object mapping
            $data = array();
            $stmt = $this->dbh->prepare("SELECT * FROM $table WHERE $var = :id");
            // $stmt->execute();
            $stmt->execute(array('id'=>$id));
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, $class);

            return $result;
        } catch (PDOException $e) {
            $logfile = fopen(ROOT_DIR.'error/error_log.txt', "a") or die("Unable to open file!");
            $txt = $e->getMessage();
            fwrite($logfile, $_SESSION['username']." ".date("M,d,Y h:i:s A") ."\n". $txt ."\n");
            fclose($logfile);
            return false;
        }
    }

    /**
     * A flexible, multipurpose function
     * @param  [string] $sql    [statement ot execute]
     * @param  [Array] $params [binding params]
     * @return [Boolean]         [True on success]
     */
    public function run($sql, $params = null)
    {
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Gets last insert id
     * @return [Integer] [last inserted id number]
     */
    public function lastinsertid()
    {
        return $this->dbh->lastInsertId();
    }
} //class
