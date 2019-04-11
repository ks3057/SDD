<?php
//This file checks for form submissions.
//It validates the submissions. Returns error in case of issue.
//If all good, inserts values to DB

//LOGIN
try {
    if (!isset($_SESSION["loggedIn"])) {
        $_SESSION["redirect"] = true;//redirect set as session variable
        header("Location: index.php");
        exit();
    }

    //USER
    if (isset($_POST['adduser'])) {
        // user cant be empty
        $valid2= $vd->isEmptyArray([$_POST['username']]);
        // no whitespaces in username
        $valid1 = $vd->isValidUsername($_POST['username']);
        //no duplicate usernames
        $sql = "SELECT username from server_user WHERE username = (?)";
        $params = [$_POST['username']];
        $res = $db->run($sql, $params)->fetchAll(PDO::FETCH_CLASS, 'User');
        if (empty($res)) {
            if ($valid2 and $valid1) {
                $success = $db->insert_data('server_user', $_POST);//
                if ($success) {
                    $successmessage = "User was added successfully with default password";
                    $_POST = array();
                    $error = "";
                } else {
                    $error = "User was not added";
                }
            } else {
                $error = "All fields are required and username must not contain whitespaces";
            }
        } else {
            $error = "User already exists";
        }
    }

    if (isset($_POST['deleteuser'])) {
        // radio button check
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            $success = $db->delete_data('server_user', 'username', $_POST['id'.$count]);
            if ($success) {
                $uvsuccess = "User was deleted successfully";
                $_POST = array();
            } else {
                $uverror = "User was not deleted, try again";
            }
        } else {
            $uverror = "Please check corresponding radio button";
        }
    }

    if (isset($_POST['resetpassword'])) {
        // radio button check
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            $success = $db->resetPassword($_POST['id'.$count]);
            if ($success) {
                $uvsuccess = "Default password set";
                $_POST = array();
            } else {
                $uverror = "Password could not be set, try again";
            }
        } else {
            $uverror = "Please check corresponding radio button";
        }
    }

    if (isset($_POST['edituser'])) {
        // check for radio button and username presence
        if (isset($_POST['opt']) and isset($_POST['username'.$_POST['opt']])) {
            $count = $_POST['opt'];
            // username cant contain spaces
            $valid1 = $vd->isValidUsername($_POST['username'.$count]);
            //check if username already exists
            $sql = "SELECT username from server_user WHERE username = (?)";
            $params = [$_POST['username'.$count]];
            $res = $db->run($sql, $params)->fetchAll(PDO::FETCH_CLASS, 'User');
            if (empty($res) and $valid1) {
                // update according to role of new user
                if ($_POST['roleid'.$count]==1) {
                    $success = $db->run("update server_user set username = ? where username = ? ", [$_POST['username'.$count], $_POST['id'.$count]]);
                    if ($success) {
                        $uvsuccess = "Updation successful";
                    } else {
                        $uverror = "Updation error";
                    }
                } elseif ($_POST['roleid'.$count] == 2) {
                    $success = $db->run("update server_user set username = ?, league = ? where username = ? ", [$_POST['username'.$count], $_POST['league'.$count], $_POST['id'.$count]]);
                    if ($success) {
                        $uvsuccess = "Updation successful";
                    } else {
                        $uverror = "Updation error";
                    }
                } else {
                    $success = $db->run("update server_user set username = ?, league = ?, team = ? where username = ? ", [$_POST['username'.$count], $_POST['league'.$count], $_POST['team'.$count], $_POST['id'.$count]]);
                    if ($success) {
                        $uvsuccess = "Updation successful";
                    } else {
                        $uverror = "Updation error";
                    }
                }
            } else {
                $uverror= "Username already exists or contains whitespaces";
            }
        } else {
            $uverror = "Please check corresponding radio button";
        }
    }

    //SPORT
    if (isset($_POST['addsport'])) {
        $spoerror = $sposuccess = "";
        // sport should not be empty
        $sarray = $vd->isEmptySport();
        $valid1 = $vd->isValidUsername($_POST['name']);
        if ($sarray[0] == true and $valid1) {
            // insert only if sport doesn't already exist
            $sql = "SELECT name from server_sport WHERE name = (?)";
            $params = [$_POST['name']];
            $res = $db->run($sql, $params)->fetchAll(PDO::FETCH_CLASS, 'Sport');
            if (empty($res)) {
                $success = $db->run("INSERT INTO server_sport(name) VALUES (?)", [$_POST['name']]);
                if ($success) {
                    $sposuccess = "Sport was added successfully";
                    $_POST = array();
                    $spoerror = "";
                } else {
                    $spoerror = "Sport was not added, try again";
                }
            } else {
                $spoerror = "Sport already exists";
            }
        } else {
            $spoerror = "Sport cannot be empty or contain whitespaces";
        }
    }

    if (isset($_POST['editsport'])) {
        //check if radio button is selected
        if (isset($_POST['opt']) and isset($_POST['name'.$_POST['opt']])) {
            $count = $_POST['opt'];
            // no duplicate sports
            if ($count>=0) {
                $stmt = "SELECT * FROM server_sport WHERE name = ?";
                $params = [$_POST['name'.$count]];
                $res = $db->run($stmt, $params)->fetchAll(PDO::FETCH_CLASS, 'Sport');
                if (empty($res)) {
                    $stmt = "UPDATE server_sport SET name = ? WHERE id = ?";
                    $success = $db->run($stmt, [$_POST['name'.$count], $_POST['id'.$count]]);
                    if ($success) {
                        $spsuccess = "Updation successful";
                        $_POST = array();
                    } else {
                        $sperror = "Updation error";
                    }
                } else {
                    $sperror = "Sport already exists";
                }
            } else {
                $sperror = "Please check its corresponding radio button";
            }
        } else {
            $sperror = "Sport cannot be blank.";
        }
    }

    if (isset($_POST['deletesport'])) {
        //check if radio button is selected
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            $success = $db->delete_data('server_sport', 'id', $_POST['id'.$count]);
            if ($success) {
                $spsuccess = "Sport was deleted successfully";
                $_POST = array();
            } else {
                $sperror = "Sport was not deleted";
            }
        } else {
            $sperror = "Please check corresponding radio button";
        }
    }

    //TEAM
    if (isset($_POST['addteam'])) {
        $sarray= $vd->isEmptyTeam();
        if ($sarray[0] == true) {
            $tsuccess = $db->insert_data('server_team', $_POST);
            if ($tsuccess) {
                $tsuccess = "Team added successfully. Please navigate to the Edit Team page to upload a picture";
                $_POST = array();
                $terror = "";
            } else {
                $terror = "Team was not added, try again";
            }
        } else {
            $terror = $sarray[1];
        }
    }

    if (isset($_POST['editteam'])) {
        //check if radio button is selected
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            // field values must not be empty
            if (!empty($_POST['name'.$count]) and !empty($_POST['mascot'.$count]) and !empty($_POST['homecolor'.$count]) and $count>=0) {
                // no duplicate teams
                $stmt = "SELECT * FROM server_team WHERE name = ?";
                $params = [$_POST['name'.$count]];
                $res = $db->run($stmt, $params)->fetchAll(PDO::FETCH_CLASS, 'Team');
                if (empty($res)) {
                    try {
                        $stmt = "UPDATE server_team SET name = ?, mascot = ?, homecolor = ?, awaycolor = ?, maxplayers = ? WHERE id = ?";
                        $success = $db->run(
                $stmt,
            [$_POST['name'.$count], $_POST['mascot'.$count], $_POST['homecolor'.$count], $_POST['awaycolor'.$count], $_POST['maxplayers'.$count], $_POST['id'.$count]]
            );
                    } catch (PDOException $e) {
                        $myfile = fopen(ROOT_DIR.'error/error_log.txt', "a") or die("Unable to open file!");
                        $txt = $e->getMessage();
                        fwrite(date('Y-m-d H:i:s'));
                        fwrite($myfile, "\n". $txt);
                        fclose($myfile);
                        return false;
                    }
                    if ($success) {
                        $teamusuccess = "Team updation successful";
                        $_POST = array();
                    } else {
                        $teamuerror = "Team updation error";
                    }
                } else {
                    $teamuerror = "Team already exists";
                }
            } else {
                $teamuerror = "Team,Mascot,Homecolor cannot be blank";
            }
        } else {
            $teamuerror = "Please check its corresponding radio button";
        }
    }

    if (isset($_POST['deleteteam'])) {
        // check for radiobutton
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            $success = $db->delete_data('server_team', 'id', $_POST['id'.$count]);
            if ($success) {
                $teamusuccess = "Team was deleted successfully";
                $_POST = array();
            } else {
                $teamuerror = "Team was not deleted";
            }
        } else {
            $teamuerror = "please check corresponding radio button";
        }
    }

    if (isset($_POST['deletepicture'])) {
        // check for radiobutton
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            $success = $db->run('update server_team set picture = null where id = ?', [$_POST['id'.$count]]);
            if ($success) {
                $teamusuccess = "Picture was deleted successfully";
                $_POST = array();
            } else {
                $teamuerror = "Picture was not deleted";
            }
        } else {
            $teamuerror = "please check corresponding radio button";
        }
    }

    //SEASON
    if (isset($_POST['addseason'])) {
        $seaerror = $seasuccess = "";
        $sarray= $vd->isEmptySeason();
        if ($sarray[0] == true and $vd->isValidYear($_POST['year'])) {
            $success = $db->run(
                "INSERT INTO server_season(year, description) VALUES (?, ?)",
            [$_POST['year'], $_POST["description"]]
          );
            if ($success) {
                $seasuccess = "Season was added successfully";
                $_POST = array();
                $seaerror = "";
            } else {
                $seaerror = "Season was not added, try again";
            }
        } else {
            $seaerror = $sarray[1];
        }
    }

    if (isset($_POST['editseason'])) {
        // check for selection
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            if (!empty($_POST['year'.$count]) and $vd->isValidYear($_POST['year'.$count]) and $count>=0) {
                // insert only if season doesn't already exist
                $sql = "SELECT year from server_season WHERE year = (?)";
                $params = [$_POST['year'.$count]];
                $res = $db->run($sql, $params)->fetchAll(PDO::FETCH_CLASS, 'Season');
                if (empty($res)) {
                    $stmt = "UPDATE server_season SET year = ? , description = ? WHERE id = ?";
                    $success = $db->run($stmt, [$_POST['year'.$count], $_POST['description'.$count], $_POST['id'.$count]]);
                    if ($success) {
                        $svsuccess = "Updation successful";
                        $_POST = array();
                    } else {
                        $sverror = "Updation error";
                    }
                } else {
                    $sverror = "Year already exists.";
                }
            } else {
                $sverror = "Year cannot be invalid/ blank.";
            }
        } else {
            $sverror = "Please check its corresponding radio button";
        }
    }

    if (isset($_POST['deleteseason'])) {
        // check for selection
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            $success = $db->delete_data('server_season', 'id', $_POST['id'.$count]);
            if ($success) {
                $svsuccess = "Season was deleted successfully";
                $_POST = array();
            } else {
                $sverror = "Season was not deleted";
            }
        } else {
            $sverror = "please check corresponding radio button";
        }
    }

    //SLSEASON
    if (isset($_POST['addslseason'])) {
        $slerror = "";
        $sarray= $vd->isEmptySLSeason();
        if ($sarray[0] == true) {
            // insert only if combination doesn't already exist
            $sql = "SELECT * from server_slseason WHERE season = (?)
        AND league = (?) AND sport = (?)";
            $params = [$_POST['season'], $_POST['league'], $_POST['sport']];
            $res = $db->run($sql, $params)->fetchAll(PDO::FETCH_CLASS, 'SLSeason');
            if (empty($res)) {
                $success = $db->run(
                "INSERT INTO server_slseason(sport, league, season) VALUES (?, ?, ?)",
            [$_POST['sport'], $_POST['league'], $_POST['season']]
          );
                if ($success) {
                    $slsuccess = "Combination was added successfully";
                    $_POST = array();
                    $slerror = "";
                } else {
                    $slerror = "Combination was not added, try again";
                }
            } else {
                $slerror = "Combination already exists";
            }
        } else {
            $slerror = $sarray[1];
        }
    }

    if (isset($_POST['editslseason'])) {
        //1. check if combination exists, if yes, exist
        //2. delete the previous combination
        //3. add the new combination
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            $sql = "SELECT * from server_slseason WHERE season = (?)
        AND league = (?) AND sport = (?)";
            $params = [$_POST['season'.$count], $_POST['league'.$count], $_POST['sport'.$count]];
            $res = $db->run($sql, $params)->fetchAll(PDO::FETCH_CLASS, 'SLSeason');
            if (empty($res)) {
                $pkeys = explode(' ', $_POST['pkey'.$count]);
                $stmt = "DELETE FROM server_slseason WHERE sport = ? and league = ? and season = ?";
                $params = [$pkeys[0], $pkeys[1], $pkeys[2]];
                $success = $db->run($stmt, $params);
                if ($success) {
                    $stmt = "INSERT INTO server_slseason(season, league, sport) VALUES (?, ?, ?)";
                    $params = [$_POST['season'.$count], $_POST['league'.$count], $_POST['sport'.$count]];
                    $success = $db->run($stmt, $params);
                    if ($success) {
                        $slvsuccess = "Combination updated";
                    } else {
                        $slverror = "Updation error";
                    }
                } else {
                    $slverror = "Deletion error";
                }
            } else {
                $slverror = "Combination already exists";
            }
        } else {
            $slverror = "please check corresponding radio button";
        }
    }

    if (isset($_POST['deleteslseason'])) {
        // check for selection and delete it
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            $pkeys = explode(' ', $_POST['pkey'.$count]);
            $stmt = "DELETE FROM server_slseason WHERE sport = ? and league = ? and season = ?";
            $params = [$pkeys[0], $pkeys[1], $pkeys[2]];
            $success = $db->run($stmt, $params);
            if ($success) {
                $slvsuccess = "Combination deleted";
            } else {
                $slverror = "deletion error";
            }
        } else {
            $slverror = "please check corresponding radio button";
        }
    }

    //PLAYER
    if (isset($_POST['editplayer'])) {
        // check for selection
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            if ($count>=0 and $vd->isEmptyArray([$_POST['firstname'.$count], $_POST['lastname'.$count], $_POST['dateofbirth'.$count], $_POST['jerseynumber'.$count], $_POST['id'.$count]])) {
                $stmt = "UPDATE server_player SET firstname = ? , lastname = ?, dateofbirth = ?, jerseynumber = ? WHERE id = ?";
                $success = $db->run($stmt, [$_POST['firstname'.$count], $_POST['lastname'.$count], $_POST['dateofbirth'.$count], $_POST['jerseynumber'.$count], $_POST['id'.$count]]);
                $stmt2 = "update server_playerpos set position = ? where player = ?";
                $success2 = $db->run($stmt2, [$_POST['position'.$count], $_POST['id'.$count]]);
                if ($success and $success2) {
                    $pvsuccess = "Updation successful";
                    $_POST = array();
                } else {
                    $pverror = "Updation error";
                }
            } else {
                $pverror = "FirstName, LastName, JerseyNumber, DOB can't be blank";
            }
        } else {
            $pverror = "please check corresponding radio button";
        }
    }

    if (isset($_POST['deleteplayer'])) {
        // check for selection
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            $success = $db->delete_data('server_player', 'id', $_POST['id'.$count]);
            if ($success) {
                $pvsuccess = "Player was deleted successfully";
                $_POST = array();
            } else {
                $pverror = "Player was not deleted, try again";
            }
        } else {
            $pverror = "Please check corresponding radio button";
        }
    }

    if (isset($_POST['addplayer'])) {
        // check for empty fields
        if ($vd->isEmptyArray([$_POST['firstname'], $_POST['lastname'], $_POST['dateofbirth'], $_POST['jerseynumber'], $_POST['team'], $_POST['position']])) {
            $success = $db->run(
            "INSERT INTO server_player(firstname, lastname, dateofbirth, jerseynumber, team) VALUES (?, ?, ?, ?, ?)",
        [$_POST['firstname'], $_POST['lastname'], $_POST['dateofbirth'], $_POST['jerseynumber'], $_POST['team']]
      );
        }
        //update player position table after player is inserted
        if ($success) {
            $id = $db->lastinsertid();
            $success2 = $db->run(
        "insert into server_playerpos values (?,?)",
        [$id, $_POST['position']]
      );
            if ($success2) {
                $pasuccess = "Player was added";
                $_POST = array();
            } else {
                $paerror = "Player was not added";
            }
        } else {
            $paerror = "Player was not added";
        }
    }

    //POSITION
    if (isset($_POST['addposition'])) {
        $poserror = $possuccess = "";
        $res= $vd->isEmptyArray([$_POST['name']]);
        if ($res == true) {
            // insert only if position doesn't already exist
            $sql = "SELECT name from server_position WHERE name = (?)";
            $params = [$_POST['name']];
            $res = $db->run($sql, $params)->fetchAll(PDO::FETCH_CLASS, 'Position');
            if (empty($res)) {
                $success = $db->run("INSERT INTO server_position(name) VALUES (?)", [$_POST['name']]);
                if ($success) {
                    $possuccess = "Position was added successfully";
                    $_POST = array();
                } else {
                    $poserror = "Position was not added, try again";
                }
            } else {
                $poserror = "Position already exists";
            }
        } else {
            $poserror = "Position name cannot be empty";
        }
    }

    //SCHEDULE
    if (isset($_POST['editschedule'])) {
        //selection check
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            $stmt = "UPDATE server_schedule set homescore = ?, awayscore = ?, completed = ?, scheduled = ? where id = ?";
            $params = [$_POST['homescore'.$count], $_POST['awayscore'.$count], $_POST['completed'.$count], $_POST['scheduled'.$count], $_POST['id'.$count]];
            $success = $db->run($stmt, $params);
            if ($success) {
                $schedvsuccess= "Updated";
            } else {
                $schedverror= "OOps something went wrong";
            }
        } else {
            $schedverror= "Please choose radio button";
        }
    }

    if (isset($_POST['deleteschedule'])) {
        //selection check
        if (isset($_POST['opt'])) {
            $count = $_POST['opt'];
            $stmt = "DELETE FROM server_schedule where id = ?";
            $params = [$_POST['id'.$count]];
            $success = $db->run($stmt, $params);
            if ($success) {
                $schedvsuccess= "deleted";
            } else {
                $schedverror= "OOps something went wrong";
            }
        } else {
            $schedverror= "Please choose radio button";
        }
    }

    if (isset($_POST['addschedule'])) {
        //selection check
        if ($vd->isEmptyArray([$_POST['ssport'], $_POST['sleague'], $_POST['sseason'],
        $_POST['hometeam'], $_POST['awayteam'], $_POST['homescore'], $_POST['awayscore'] ,
        $_POST['scheduled']])) {
            // since default value is 0 for bit column, no value is inserted
            if ($_POST['completed'] == 1) {
                $stmt = "INSERT INTO server_schedule(sport,league,season,hometeam,awayteam,homescore,awayscore,scheduled,completed) VALUES(?,?,?,?,?,?,?,?,?)";
                $params = [$_POST['ssport'], $_POST['sleague'], $_POST['sseason'],
              $_POST['hometeam'], $_POST['awayteam'], $_POST['homescore'], $_POST['awayscore'] ,
              $_POST['scheduled'], $bool];
            } else {
                $stmt = "INSERT INTO server_schedule(sport,league,season,hometeam,awayteam,homescore,awayscore,scheduled) VALUES(?,?,?,?,?,?,?,?)";
                $params = [$_POST['ssport'], $_POST['sleague'], $_POST['sseason'],
              $_POST['hometeam'], $_POST['awayteam'], $_POST['homescore'], $_POST['awayscore'] ,
              $_POST['scheduled']];
            }
            $success = $db->run($stmt, $params);
            if ($success) {
                $schedvsuccess = "Schedule added";
            } else {
                $schedverror= "Oops something went wrong";
            }
        } else {
            $schedverror= "All fields are required";
        }
    }
}//try
 catch (PDOException $e) {
     $logfile = fopen(ROOT_DIR.'error/error_log.txt', "a") or die("Unable to open file!");
     $txt = $e->getMessage();
     fwrite($logfile, $_SESSION['username']." ".date("M,d,Y h:i:s A") ."\n". $txt ."\n");
     fclose($logfile);
     return false;
 }
