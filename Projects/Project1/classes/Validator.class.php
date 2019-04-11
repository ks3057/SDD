<?php
class Validator
{
    /**
     * Sanitises all input
     * @param  [String] $data [data to be sanitized]
     * @return [String]       [sanitised data]
     */
    public function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * Checks if user fields are empty
     * @param  [Array]  $postarr [The required fields]
     * @return boolean          [false if any field is empty]
     */
    public function isEmptyUser($postarr)
    {
        $error = "";
        $flag = true;
        if (empty($postarr["username"])) {
            $error = "Username is required";
            $flag = false;
        } else {
            $postarr["username"] = $this->test_input($postarr["username"]);
            if (empty($postarr["role"])) {
                $error = "Role is required";
                $flag = false;
            } else {
                if (empty($postarr["league"]) and $_POST['role']!=1) {
                    $error = "League is required";
                    $flag = false;
                } else {
                    if (empty($postarr["team"]) and $_POST['role']!=1) {
                        $error = "Team is required";
                        $flag = false;
                    }
                }
            }
        }
        return array($flag,$error);
    }

    /**
     * Valid username is one not containing spaces
     * @param  [String]  $username [username to be checked]
     * @return boolean           [false is contains space]
     */
    public function isValidUsername($username)
    {
        $flag = true;
        if (preg_match('/\s/', $username)) {
            $flag = false;
        }
        return $flag;
    }

    /**
     * Check if sport fields are empty
     * @return boolean [false if any field is empty]
     */
    public function isEmptySport()
    {
        $error = "";
        $flag = true;
        if (empty($_POST["name"])) {
            $error = "Sport name is required";
            $flag = false;
        } else {
            $_POST["name"] = $this->test_input($_POST["name"]);
            if (!preg_match("/^[a-zA-Z ]*$/", $_POST["name"])) {
                $error = "Only letters and white space allowed";
                $flag = false;
            }
        }
        return array($flag, $error);
    }

    /**
     * Check if team fields are empty
     * @return boolean [false if any field is empty]
     */
    public function isEmptyTeam()
    {
        $error = "";
        $flag = true;
        if (empty($_POST["name"]) or empty($_POST["tsport"]) or empty($_POST["tseason"])
        or empty($_POST["tleague"])) {
            $error = "Name, sport, league and season are required fields";
            $flag = false;
        }
        return array($flag, $error);
    }

    /**
     * Check if season fields are empty
     * @return boolean [false if any field is empty]
     */
    public function isEmptySeason()
    {
        $error = $desc = "";
        $flag = true;
        if (empty($_POST["year"])) {
            $error = "Year is required";
            $flag = false;
        } else {
            $_POST["year"] = $this->test_input($_POST["year"]);
            if (empty($_POST["description"])) {
                $error = "Description is required";
                $flag = false;
            } else {
                $desc = $_POST["description"];
            }
        }
        return array($flag, $error);
    }

    /**
     * Checks if SLSeason combination is empty
     * @return boolean [false if any field is empty]
     */
    public function isEmptySLSeason()
    {
        $error = "";
        $flag = true;
        if (empty($_POST["sport"])) {
            $error = "Sport is required";
            $flag = false;
        } elseif (empty($_POST["league"])) {
            $error = "League is required";
            $flag = false;
        } elseif (empty($_POST["season"])) {
            $error = "Season is required";
            $flag = false;
        } else {
            $flag = true;
        }
        return array($flag, $error);
    }

    /**
     * Year to be inserted in season should be valid
     * @param  [Integer]  $year [Year to be validated]
     * @return boolean       [True if within range]
     */
    public function isValidYear($year)
    {
        $year = (int)$year;
        if ($year>1000 && $year<2100) {
            return true;
        }
        return false;
    }

    public function isEmptyArray($array)
    {
        $flag = true;
        foreach ($array as $key) {
            if (empty($key)) {
                $flag = false;
                break;
            }
        }
        return $flag;
    }
}
