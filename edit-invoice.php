<?php

session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Edit invoice';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';
$infoMsg      = '';

if (isset($_GET['action'])) {
    if ($_GET['action'] == "saved") {
        $successMsg .= 'The invoice has been saved successfully.';
    } elseif($_GET['action'] == "send") {
        $successMsg .= 'The invoice <b>'.$_GET['invoicenr'].'</b> has been send to <b>'.$_GET['email'].'</b>.';
    }
}

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$query = mysqli_query($db, "SELECT * FROM invntry_taxes WHERE userID='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."' ORDER BY taxRate DESC") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

while ($fetch = mysqli_fetch_assoc($query)) {
    $taxes[] = array(
        'taxID'=>$fetch['taxID'],
        'taxName'=>$fetch['taxName'],
        'taxRate'=>$fetch['taxRate'],
    );
}


    /////////////// User data /////////////

$query = mysqli_query($db, "SELECT * FROM invntry_users WHERE userID='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'") or die(mysqli_error($db));
$fetch = mysqli_fetch_assoc($query);

$tpl->assign('userName', $fetch['userFullname']);
$tpl->assign('userCompany', $fetch['userCompanyname']);
$tpl->assign('userAddress', $fetch['userAddress']);
$tpl->assign('bankAccount', $fetch['setBankAccount']);
$tpl->assign('invoiceLogo', $fetch['setLogo']);


$query = mysqli_query($db, "SELECT * FROM invntry_invoices WHERE invoiceID='".mysqli_real_escape_string($db, $_GET['id'])."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);


$tpl->assign('currency', getCurrency($db, $_SESSION['login_userId']));
$tpl->assign('invoiceClientID', $row['invoiceClientID']);
$tpl->assign('invoiceClientAddress', str_replace("<br />", "\n", $row['invoiceClientAddress']));
$tpl->assign('invoiceAddress', str_replace("<br />", "\n", $row['invoiceAddress']));
$tpl->assign('invoiceNr', $row['invoiceNr']);
$tpl->assign('invoiceDate', $row['invoiceDate']);
$tpl->assign('invoiceDuedate', $row['invoiceDuedate']);
//$tpl->assign('invoiceTotalDue', $row['invoiceTotalDue']);
$tpl->assign('invoiceSubtotal', number_format($row['invoiceSubtotal'], 2));
$tpl->assign('invoiceTax', number_format($row['invoiceTax'], 2));
$tpl->assign('invoiceTaxRate', $row['invoiceTaxRate']);
$tpl->assign('invoiceTotal', number_format($row['invoiceTotal'], 2));
//$tpl->assign('invoiceTotalPaid', $row['invoiceTotalPaid']);
$tpl->assign('invoiceNote', $row['invoiceNote']);
$tpl->assign('invoiceID', $_GET['id']);
$tpl->assign('clientID', $row['invoiceClientID']);


// Get client data for dropdown
$query = mysqli_query($db, "SELECT * FROM invntry_clients ORDER BY clientFirstname DESC") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

while ($fetch = mysqli_fetch_assoc($query)) {
    if (($fetch['clientFirstname'] == '') and ($fetch['clientLastname'] == '')) {
        $clientName = $fetch['clientCompany'];
    } else {
        $clientName = $fetch['clientCompany'];
    }
    $clients[] = array(
        'clientID'=>$fetch['clientID'],
        'clientName'=>$fetch['clientFirstname'] . ' ' . $fetch['clientLastname'] . ' / ' . $fetch['clientCompany'],
        'clientCompany'=>$fetch['clientCompany'],
        'clientEmail'=> $fetch['clientEmailaddress'],
    );
}

// Get selected client data
$query = mysqli_query($db, "SELECT * FROM invntry_clients WHERE clientID = '" . $row['invoiceClientID'] . "'") or die(mysqli_error($db));
$row = mysqli_fetch_assoc($query);

$invoice_name_to = '';
$invoice_address_to = '';

if (($row['clientFirstname'] != '') && ($row['clientLastname'] != '')) {
    $clientFullname = $row['clientFirstname'] . " " . $row['clientLastname'];
    $invoice_name_to .= '' . $clientFullname;
} 

if ($row['clientCompany'] != '') {
    $invoice_address_to .= '

    ' . $row['clientCompany'];
} 
if ($row['clientAddress1'] != '') {
    $invoice_address_to .= '
    ' . $row['clientAddress1'] . '';
} 
if ($row['clientAddress2'] != '') {
    $invoice_address_to .= '
    ' . $row['clientAddress2'] . '';
} 
if ($row['clientCity'] != '') {
    $invoice_address_to .= '
    ' . $row['clientCity'] . ' ';
} 
if ($row['clientCountry'] != '') {
    $invoice_address_to .= ', ' . $row['clientCountry'];
} 
if ($row['clientZipcode'] != '') {
    $invoice_address_to .= '
    ' . $row['clientZipcode'];
}

$tpl->assign('clientNameto', $invoice_name_to);
$tpl->assign('clientAddressto', $invoice_address_to);
    
$query = mysqli_query($db, "SELECT * FROM invntry_invoices_items WHERE invoiceID='".mysqli_real_escape_string($db, $_GET['id'])."' ORDER BY itemName") or die(mysqli_error($db));
$itemResult = mysqli_num_rows($query);

if ($itemResult == 0) {
    $items = '';
} else {
    while ($fetch2 = mysqli_fetch_assoc($query)) {
        $q = mysqli_query($db, "SELECT * FROM invntry_items WHERE itemID='".$fetch2['itemID']."'") or die(mysqli_error($db));
        $h = mysqli_fetch_assoc($q);

        //echo "id => ".$fetch2['itemID'].", qty => ".$h['itemQuantity']."<br/>";

        $items[] = array(
            'itemID'=>$h['itemID'],
            'itemName'=>$fetch2['itemName'],
            'itemDescription'=>$fetch2['itemDescription'],
            'itemPrice'=>number_format($fetch2['itemPrice'], 2),
            'itemQuantity'=>$fetch2['itemQty'],
            'infinity'=>$h['infinity'],
            'itemPriceTotal'=>number_format($fetch2['itemPriceTotal'], 2),
            'hiddenQty'=>$h['itemQuantity'],
        );


    }
}  

$tpl->assign('setCurrency', $fetch['setCurrency']);

$tpl->assign('clients', $clients);
$tpl->assign('taxes', $taxes);
$tpl->assign('items', $items);
$tpl->assign('pageTitle', 'Edit invoice');
$tpl->assign('page', 'invoices');

$tpl->assign('itemCounter', $itemResult);

$tpl->assign('userFullname', $_SESSION['login_userfname']);

$html = $tpl->draw('edit-invoice');
?>