<?php 
session_start();
include_once("config.php");

if (isset($_SESSION['login_userId'])) {
    header("location: items.php");
}

// converts text to safe output (prevents cross-site-scripting)
function mkSafe($text) 
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// Return ajax call by checking if user is logged in
if (isset($_GET['check'])) {
    if ($_GET['check'] == "login") {
        if (isLoggedin($db) == true) {
            echo 'true';
        } else {
            echo 'false';
        }
    } 
} elseif (isset($_GET['logout'])) {
    session_destroy();
    header("location: login.php");
} else {
    if (isset($_POST['username'])) {
        $password = mysqli_real_escape_string($db, mkSafe(hash('sha512', $_POST['password'])));
        $username = mysqli_real_escape_string($db, mkSafe($_POST['username']));
        $login    = mysqli_num_rows(mysqli_query($db, "SELECT userID FROM invntry_users WHERE userEmailaddress='".$username."' AND userPassword='".$password."'"));
        if ($login == 1) {
            $query = mysqli_query($db, "SELECT * FROM invntry_users WHERE userEmailaddress='".$username."' AND userPassword='".$password."'") or die(mysql_error());
            $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    
            $_SESSION['login']          = 1;
            $_SESSION['login_hash']     = hash("sha512", $row['userEmailaddress'] . $row['userID']);
            $_SESSION['login_username'] = $row['userEmailaddress'];
            $_SESSION['login_userfname']   = $row['userFullname'];
            $_SESSION['login_userId']   = $row['userID'];

            //header("location: items.php");
            echo 'true';
        } else {
            echo 'You entered wrong login information, please try again';
        }

    } else {
    
    	//include the RainTPL class
	include "resources/libraries/raintpl/rain.tpl.class.php";

	raintpl::configure("tpl_dir", "resources/templates/" );
	raintpl::configure("cache_dir", "tmp/" );

	//initialize a Rain TPL object
	$tpl = new RainTPL;
	
	$html = $tpl->draw('login');
    }
}
?>