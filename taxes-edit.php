<?php 


session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Edit tax rate';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';
$infoMsg      = '';

if (isset($_POST['Submit'])) {
    
    $taxRate = str_replace("%", "", $_POST['taxRate']);
    
    if(mysqli_query($db, "UPDATE invntry_taxes SET
        taxName = '".mysqli_real_escape_string($db, $_POST['taxName'])."',
        taxRate = '".mysqli_real_escape_string($db, $taxRate)."'
        WHERE taxID = '".mysqli_real_escape_string($db, $_GET['id'])."' AND userID='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'")) {
            $successMsg = 'The changes to the tax rate have been saved.';
    } else {
        $errorMsg .= 'The changes could not be saved to the database.';
    }
}

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$query = mysqli_query($db, "SELECT * FROM invntry_taxes WHERE taxID='".mysqli_real_escape_string($db, $_GET['id'])."' AND userID='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);

if ($result == 0) {
    $errorMsg .= 'There is no tax rate with the given tax ID.';
} else {
    $infoMsg .= 'Edit the form fields below and click save. Fields are not mandatory.';

    $tpl->assign('taxName', $row['taxName']);
    $tpl->assign('taxRate', ''.$row['taxRate'].'%');
}

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('infoMsg', $infoMsg);
$tpl->assign('page', 'taxes');
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$tpl->assign('userFullname', $_SESSION['login_userfname']);

$html = $tpl->draw('taxes-edit');
?>