<?php 


session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Add new client';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';
$infoMsg      = '';

if (isset($_GET['action'])) {
    if ($_GET['action'] == "saved") {
        $successMsg .= 'The client has been saved successfully.';
    } 
}

if (isset($_POST['Save'])) {
    if(mysqli_query($db, "INSERT INTO invntry_clients (
        clientCompany,
        clientFirstname,
        clientLastname,
        clientAddress1,
        clientAddress2,
        clientCity,
        clientCountry,
        clientZipcode,
        clientEmailaddress,
        clientPhonenumber
        ) VALUES (
        '".mysqli_real_escape_string($db, $_POST['clientCompany'])."',
        '".mysqli_real_escape_string($db, $_POST['clientFirstname'])."',
        '".mysqli_real_escape_string($db, $_POST['clientLastname'])."',
        '".mysqli_real_escape_string($db, $_POST['clientAddress1'])."',
        '".mysqli_real_escape_string($db, $_POST['clientAddress2'])."',
        '".mysqli_real_escape_string($db, $_POST['clientCity'])."',
        '".mysqli_real_escape_string($db, $_POST['clientCountry'])."',
        '".mysqli_real_escape_string($db, $_POST['clientZipcode'])."',
        '".mysqli_real_escape_string($db, $_POST['clientEmailaddress'])."',
        '".mysqli_real_escape_string($db, $_POST['clientPhonenumber'])."'
        )")){
        
            header("location: clients.php?action=saved");
    } else {
        $errorMsg .= 'The client could not be saved to the database.';
    }
}

if (isset($_POST['SaveAdd'])) {
    if(mysqli_query($db, "INSERT INTO invntry_clients (
        clientCompany,
        clientFirstname,
        clientLastname,
        clientAddress1,
        clientAddress2,
        clientCity,
        clientCountry,
        clientZipcode,
        clientEmailaddress,
        clientPhonenumber
        ) VALUES (
        '".mysqli_real_escape_string($db, $_POST['clientCompany'])."',
        '".mysqli_real_escape_string($db, $_POST['clientFirstname'])."',
        '".mysqli_real_escape_string($db, $_POST['clientLastname'])."',
        '".mysqli_real_escape_string($db, $_POST['clientAddress1'])."',
        '".mysqli_real_escape_string($db, $_POST['clientAddress2'])."',
        '".mysqli_real_escape_string($db, $_POST['clientCity'])."',
        '".mysqli_real_escape_string($db, $_POST['clientCountry'])."',
        '".mysqli_real_escape_string($db, $_POST['clientZipcode'])."',
        '".mysqli_real_escape_string($db, $_POST['clientEmailaddress'])."',
        '".mysqli_real_escape_string($db, $_POST['clientPhonenumber'])."'
        )")){
        
            header("location: clients-add.php?action=saved");
    } else {
        $errorMsg .= 'The client could not be saved to the database.';
    }
}

$infoMsg .= 'Fill out the form fields below to add a new client. All fields are mandatory.';

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('infoMsg', $infoMsg);
$tpl->assign('page', 'clients');
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$html = $tpl->draw('clients-add');
?>