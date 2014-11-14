<?php


session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle = 'INVNTRY &trade; settings';
$pageContent = '';
$errorMsg = '';
$successMsg = '';
$infoMsg = '';

// Converts linebreaks to <br>
function lineBreaks($text) 
{ 
    return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />')); 
} 

if (isset($_POST['Submit'])) {

    if (mysqli_query($db, "UPDATE invntry_users SET
    setCurrency = '".mysqli_real_escape_string($db, $_POST['setCurrency'])."',
    setInvoiceAddress = '".mysqli_real_escape_string($db, lineBreaks($_POST['setInvoiceAddress']))."',
    setBankAccount = '".mysqli_real_escape_string($db, lineBreaks($_POST['setBankAccount']))."',
    setDefaultName = '".mysqli_real_escape_string($db, $_POST['setDefaultName'])."',
    setDefaultSubject = '".mysqli_real_escape_string($db, $_POST['setDefaultSubject'])."',
    setDefaultEmail = '".mysqli_real_escape_string($db, $_POST['setDefaultEmail'])."',
    setDefaultMsg = '".mysqli_real_escape_string($db, $_POST['setDefaultMsg'])."'
    WHERE userID='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'
    ")) {
    

    $upload_dir = 'uploads/logos/';
    $random = rand(00000, 99999) . '_';
    
    // Check if logo filetype is GIF, JPG or PNG and upload logo
    $ext = pathinfo($_FILES['setLogo']['name'], PATHINFO_EXTENSION);
    $allowed = array('jpg','png','gif');
    if (!in_array($ext, $allowed)) {
        $logo_src = '';
    } else {
        if(move_uploaded_file($_FILES['setLogo']['tmp_name'], $upload_dir . $random . $_FILES['setLogo']['name'])) {
            $logo_src = $upload_dir . $random .  $_FILES['setLogo']['name'];
            
            mysqli_query($db, "UPDATE invntry_users SET
            setLogo = '".mysqli_real_escape_string($db, $logo_src)."'
            WHERE userID = '".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'
            ") or die(mysqli_error());
            
        } else {  
            $logo_src = '';
            $errorMsg .= 'Your logo could not be uploaded, please try again.';
        }
    }
    
    
 
        $successMsg .= 'Your changes have been successfully been saved.';
   } else {
   
        $errorMsg .= 'Your changes could not be saved to the database.';
   }
}

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;
	
$query = mysqli_query($db, "SELECT * FROM invntry_users WHERE userID='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'") or die(mysqli_error($db));
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);

$tpl->assign('setCurrency', $row['setCurrency']);
$tpl->assign('setLogo', $row['setLogo']);
$tpl->assign('setInvoiceAddress', str_replace("<br />", "\n", $row['setInvoiceAddress']));
$tpl->assign('setBankAccount', str_replace("<br />", "\n", $row['setBankAccount']));
$tpl->assign('setDefaultName', $row['setDefaultName']);
$tpl->assign('setDefaultSubject', $row['setDefaultSubject']);
$tpl->assign('setDefaultEmail', $row['setDefaultEmail']);
$tpl->assign('setDefaultMsg', $row['setDefaultMsg']);

$tpl->assign('infoMsg', 'Edit the fields below and click \'save changes\'.');
$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('infoMsg', $infoMsg);
$tpl->assign('pageTitle', $pageTitle);

$tpl->assign('userFullname', $_SESSION['login_userfname']);

$tpl->assign('page', 'settings');
$html = $tpl->draw('settings');
?>