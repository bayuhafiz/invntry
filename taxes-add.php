<?php 


session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Add new tax rate';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';
$infoMsg      = '';

if (isset($_POST['Submit'])) {
    
    $taxRate = str_replace("%", "", $_POST['taxRate']);
    
    if(mysqli_query($db, "INSERT INTO invntry_taxes (
        userID,
        taxName,
        taxRate
        ) VALUES (
        '".mysqli_real_escape_String($db, $_SESSION['login_userId'])."',
        '".mysqli_real_escape_string($db, $_POST['taxName'])."',
        '".mysqli_real_escape_string($db, $taxRate)."'
        )")) {
        
        header("location: taxes.php?action=saved");
    } else {
        $errorMsg .= 'The tax rate could not be saved to the database.';
    }
}

$infoMsg .= 'Fill out the form fields below to add a new tax rate. Fields are not mandatory.';

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('infoMsg', $infoMsg);
$tpl->assign('page', 'taxes');
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);
$tpl->assign('userFullname', $_SESSION['login_userfname']);

$html = $tpl->draw('taxes-add');
?>