<?php
require "classes/DB.class.php";
require_once "config.php";
$redirectURL = "https://serenity.ist.rit.edu/~ks3057/756/Projects/Project1/fb-callback.php";
$permissions = ['email'];
$loginURL = $helper->getLoginUrl($redirectURL, $permissions);
$db = new DB();
session_start();
$msg="";

if (isset($_SESSION["redirect"])) {
    $page_display = "You need to login";
    unset($_SESSION["redirect"]); // redirect should be false in login page
} elseif (isset($_SESSION["loggedIn"])) {
    header("Location: admin.php");
    exit(); //prevent code below from executing after redirection
} else {
    //if form submitted, check login values with DB
    global $msg;
    if (isset($_POST["submit"])) {
        if (isset($_POST["g-recaptcha-response"]) and $_POST["g-recaptcha-response"]) {

            $ip = $_SERVER['REMOTE_ADDR'];
            $captcha = $_POST["g-recaptcha-response"];
            $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
            $arr = json_decode($rsp, true);
            //if captcha success
            if ($arr['success']) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $data = $db->getUser($username);
                if ($data != false) {
                    $isPasswordCorrect = password_verify($_POST['password'], $data->__get('password'));
                    if ($isPasswordCorrect) {
                        $_SESSION["loggedIn"] = true;
                        $_SESSION['username'] = $_POST['username'];
                        $_SESSION['role'] = $data->__get('role');
                        $_SESSION['league'] = $data->__get('league');
                        $_SESSION['team'] = $data->__get('team');
                        if ($_SESSION['role'] !=5) {
                            $logfile = fopen(ROOT_DIR.'error/error_log.txt', "a") or die("Unable to open file!");
                            fwrite($logfile, "\n".$_SESSION['username']." ".date("M,d,Y h:i:s A") ."\n". "login");
                            fclose($logfile);
                            header("Location: admin.php");
                            exit();
                        } else {
                            header("Location: team.php");
                            exit();
                        }
                    } else {
                        $msg = "Invalid login";
                    }
                } else {
                    $msg = "Invalid login";
                }
            } else {
                $msg = 'Spam!';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body id="home">
	<form method="post" action="" id="addphone">

  <div class="simple-login-container">
    <h1>Head Start</h1>
    <h2>Login Form</h2>
    <h3><?php echo $msg ?></h3>
    <div class="row">
        <div class="col-md-12 form-group">
            <input type="text" class="form-control" placeholder="Username" name="username">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <input type="password" placeholder="Enter your Password" class="form-control" name="password">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <div class="g-recaptcha" data-sitekey="6Lfyf5kUAAAAAGE0Vc9OBAlGwOY6CoaIf-8W9CEB"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <input type="submit" class="btn btn-block btn-login" placeholder="Enter your Password" value="Login" name="submit">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <input type="button" onclick="window.location = '<?php echo $loginURL; ?>'" class="btn btn-block btn-login" value="Login with Facebook" name="loginFB">
        </div>
    </div>

</div>
</form>
</body>
</html>
