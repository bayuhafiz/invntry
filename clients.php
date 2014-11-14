<?php 
session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Clients';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';

if (isset($_GET['action'])) {
    if ($_GET['action'] == "saved") {
        $successMsg .= 'The client has been saved successfully.';
    } 
    elseif($_GET['action'] == "delete") {
        if (isset($_GET['id'])) {
            if (mysqli_query($db, "DELETE FROM invntry_clients WHERE clientID='".mysqli_real_escape_string($db, $_GET['id'])."'")) {
                $successMsg .= 'The client has been deleted successfully.';
            } else {
                $errorMsg .= 'The client could not be deleted.';
            }
        } else {
            $errorMsg .= 'No client ID has been received. Without a client ID the client can\'t be deleted.';
        }
    }
}

$query = mysqli_query($db, "SELECT * FROM invntry_clients ORDER BY clientLastname DESC") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

if ($result == 0) {
    $pageContent .= '<p>There are currently no clients, start by adding a <a href="clients-add.php">new client</a>.</p>';
    $clients = '';
} else {
    $pageContent .= '<p>There are <strong>'.$result.'</strong> clients.</p>';

    while ($fetch = mysqli_fetch_assoc($query)) {
        $clients[] = array(
            'clientID'=>$fetch['clientID'],
            'clientFirstname'=>$fetch['clientFirstname'],
            'clientLastname'=>$fetch['clientLastname'],
            'clientCompany'=>$fetch['clientCompany'],
            'clientEmail'=> $fetch['clientEmailaddress'],
            'clientAddress1'=> $fetch['clientAddress1'],
            'clientAddress2'=> $fetch['clientAddress2'],
            'clientCity'=> $fetch['clientCity'],
            'clientCountry'=> $fetch['clientCountry'],
            'clientZipcode'=> $fetch['clientZipcode'],
            'clientPhonenumber'=> $fetch['clientPhonenumber']
        );
    }  
}
    
include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('page', 'clients');
$tpl->assign('clients', $clients);
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$tpl->assign('userFullname', $_SESSION['login_userfname']);

$html = $tpl->draw('clients');
?>