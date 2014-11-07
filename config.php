<?php
global $db;
global $productid;

// Your database login: host, user, password, database
$db = mysqli_connect("68.178.143.52", "invntrydatabase", "Jalanpemuda#60", "invntrydatabase");

if (mysqli_connect_errno($db)) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function getCurrency ($db, $userID)
{
    $query = mysqli_query($db, "SELECT setCurrency FROM invntry_users WHERE userID='".mysqli_real_escape_string($db, $userID)."'") or die(mysql_error());
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    
    if ($row['setCurrency'] == "euro") {
        return '&euro;';
    } elseif ($row['setCurrency'] == "usd") {
        return '$';
    }
}

// checks if user is logged in for admin panel
function isLoggedin ($db)
{
    if (isset($_SESSION['login'])) {
    
        $query = mysqli_query($db, "SELECT * FROM invntry_users WHERE userFullname='".mysqli_real_escape_string($db, $_SESSION['login_userfname'])."'") or die(mysql_error());
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        
        if ($_SESSION['login_hash'] == hash('sha512', $row['userEmailaddress'] . $row['userID'])) {
            //$_SESSION['userfname'] = $row['userFullname'];
            return true;
        } else {
            session_destroy();
            return false;
        }
    } else {
      session_destroy();
      header('Location:login.php');
      //return false;
    }
}

if (isset($_GET['productid'])) {
    if (!empty($_GET['productid'])) {
         $productid = $_GET['productid'];  
    } else {
       $productid = '';  
    }
} else {
    $productid = '';
}
?>