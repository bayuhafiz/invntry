<?php
session_start();
include_once("config.php");
isLoggedin($db);

// ------------------------  Get the taxes
$query = mysqli_query($db, "SELECT * FROM invntry_taxes WHERE userID='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."' ORDER BY taxRate DESC") or die(mysqli_error($db));
$result = mysqli_num_rows($query);
while ($fetch = mysqli_fetch_assoc($query)) {
    $taxes[] = array(
        'taxID'=>$fetch['taxID'],
        'taxName'=>$fetch['taxName'],
        'taxRate'=>$fetch['taxRate'],
    );
}

// --------------------------  Get the clients list    
$query = mysqli_query($db, "SELECT * FROM invntry_clients ORDER BY clientFirstname DESC") or die(mysqli_error($db));
$result = mysqli_num_rows($query);
while ($fetch = mysqli_fetch_assoc($query)) {
    $clientFullname = $fetch['clientFirstname'] . "&nbsp;" . $fetch['clientLastname'];

    $clients[] = array(
        'clientID'=>$fetch['clientID'],
        'clientName'=>$clientFullname . ' / ' . $fetch['clientCompany'],
        'clientCompany'=>$fetch['clientCompany'],
        'clientEmail'=> $fetch['clientEmailaddress'],
    );
}

// -----------------------------  Get infos from user 
$query = mysqli_query($db, "SELECT * FROM invntry_users WHERE userID='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'") or die(mysqli_error($db));
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);

$userID = $row['userID'];
$userFullname = $row['userFullname'];
$userCompanyname = $row['userCompanyname'];
$userAddress = $row['userAddress'];
$invoiceAddress = $row['setInvoiceAddress'];
$bankAccount = $row['setBankAccount'];
$invoiceLogo = $row['setLogo'];

$query = mysqli_query($db, "SELECT invoiceID FROM invntry_invoices WHERE userID='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

$invoiceNr = $result + 1;
$invoiceNr = date("Y") . str_pad($invoiceNr, 4, "0", STR_PAD_LEFT);


// ///////////////////// Get picked items //////////////////////
if (isset($_POST['check_list'])) { // check if checkboxes checked
    if(!empty($_POST['check_list'])) {
        $i = 0;
        foreach($_POST['check_list'] as $check) {

            $query = mysqli_query($db, "SELECT * FROM invntry_items WHERE itemId = '" . $check . "'") or die(mysqli_error($db));
            $fetch = mysqli_fetch_assoc($query);

                $itemTotal = number_format($fetch['itemPrice'],2, '.', '') * number_format($fetch['itemQuantity']);

                $pickedItems[] = array(
                    'itemID'=>$fetch['itemID'],
                    'itemName'=>$fetch['itemName'],
                    'itemDescription'=>$fetch['itemDescription'],
                    'itemPrice'=> number_format($fetch['itemPrice'], 2, '.', ''),
                    'itemQuantity'=> $fetch['itemQuantity'],
                    'itemTotal'=> number_format($itemTotal, 2, '.', ','),
                    'infinity'=> $fetch['infinity'],
                    'itemImage'=> $fetch['itemImage']
                );

            $i++;
            
        }
    }

} else {
    $pickedItems = '';
}


include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;
	
$tpl->assign('currency', getCurrency($db, $_SESSION['login_userId']));
$tpl->assign('invoiceNr', $invoiceNr);
$tpl->assign('invoiceTaxes', $taxes);
//$tpl->assign('itemsList', $itemsList);
$tpl->assign('clients', $clients);
$tpl->assign('invoiceAddress', $invoiceAddress);
$tpl->assign('bankAccount', $bankAccount);
$tpl->assign('invoiceLogo', $invoiceLogo);
$tpl->assign('pickedItems', $pickedItems);

$tpl->assign('userID', $userID);
$tpl->assign('userFullname', $userFullname);
$tpl->assign('userCompanyname', $userCompanyname);
$tpl->assign('userAddress', $userAddress);

if (isset($_POST['check_list'])) { 
    $tpl->assign('itemCounter', $i); 
} else {
    $tpl->assign('itemCounter', 0); 
}

$tpl->assign('pageTitle', 'New invoice');
$tpl->assign('page', 'invoices');
$tpl->assign('invoiceDate', date("F j, Y"));
$tpl->assign('dueDate', date("F j, Y",strtotime("+2 week")));

$tpl->assign('userFullname', $_SESSION['login_userfname']);

$html = $tpl->draw('create-invoice');
?>