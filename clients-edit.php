<?php 


session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Edit client';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';
$infoMsg      = '';

if (isset($_POST['Submit'])) {

    if(mysqli_query($db, "UPDATE invntry_clients SET
        clientCompany = '".mysqli_real_escape_string($db, $_POST['clientCompany'])."',
        clientFirstname = '".mysqli_real_escape_string($db, $_POST['clientFirstname'])."',
        clientLastname = '".mysqli_real_escape_string($db, $_POST['clientLastname'])."',
        clientAddress1 = '".mysqli_real_escape_string($db, $_POST['clientAddress1'])."',
        clientAddress2 = '".mysqli_real_escape_string($db, $_POST['clientAddress2'])."',
        clientCity = '".mysqli_real_escape_string($db, $_POST['clientCity'])."',
        clientCountry = '".mysqli_real_escape_string($db, $_POST['clientCountry'])."',
        clientZipcode = '".mysqli_real_escape_string($db, $_POST['clientZipcode'])."',
        clientEmailaddress = '".mysqli_real_escape_string($db, $_POST['clientEmailaddress'])."',
        clientPhonenumber = '".mysqli_real_escape_string($db, $_POST['clientPhonenumber'])."'

        WHERE clientID = '".mysqli_real_escape_string($db, $_GET['id'])."'")){
        
            $successMsg = 'The changes to the client have been saved.';
            
    } else {
        $errorMsg .= 'The changes could not be saved to the database.';
    }
}

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$query = mysqli_query($db, "SELECT * FROM invntry_clients WHERE clientID='".mysqli_real_escape_string($db, $_GET['id'])."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);

if ($result == 0) {
    $errorMsg .= 'There is no client with the given client ID.';
} else {
    $infoMsg .= 'Edit the form fields below and click save. All fields are mandatory.';
    $tpl->assign('clientCompany', $row['clientCompany']);
    $tpl->assign('clientFirstname', $row['clientFirstname']);
    $tpl->assign('clientLastname', $row['clientLastname']);
    $tpl->assign('clientAddress1', $row['clientAddress1']);
    $tpl->assign('clientAddress2', $row['clientAddress2']);
    $tpl->assign('clientCity', $row['clientCity']);
    $tpl->assign('clientCountry', $row['clientCountry']);
    $tpl->assign('clientZipcode', $row['clientZipcode']);
    $tpl->assign('clientEmailaddress', $row['clientEmailaddress']);
    $tpl->assign('clientPhonenumber', $row['clientPhonenumber']);
}

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('infoMsg', $infoMsg);
$tpl->assign('page', 'clients');
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$html = $tpl->draw('clients-edit');
?>