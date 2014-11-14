<?php 
session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Edit item';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';
$infoMsg      = '';

if (isset($_POST['Submit'])) {

    $itemPrice = str_replace(",", "", $_POST['itemPrice']);

    //echo $itemPrice; break;

     // Get the infinity radio button value
    $infinity = $_POST['infinity'];
    if ($infinity == '1') {
        $itemQuantity = 1;
    } else {
        $itemQuantity = mysqli_real_escape_string($db, $_POST['itemQuantity']);
    }

    if (isset($_FILES['itemImage'])) {
        // Item image processing
        $upload_dir = 'uploads/items/';
        $img_src = "";

        $query = mysqli_query($db, "SELECT itemImage FROM invntry_items WHERE itemID = '".$_GET['id']."'") or die(mysqli_error($db));
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);

        $key = rand(00000, 99999) . '_';

            if ($_FILES['itemImage']['name'] != '') {
                unlink($row['itemImage']);
                move_uploaded_file($_FILES['itemImage']['tmp_name'], $upload_dir . $key . $_FILES['itemImage']['name']);
                $img_src = $upload_dir . $key .  $_FILES['itemImage']['name'];
            } else {  
                $img_src = $row['itemImage'];
                //$errorMsg .= 'Item image could not be uploaded, please try again.';
            }
    }
    
    //echo $img_src; break;

    if(mysqli_query($db, "UPDATE invntry_items SET
        itemName = '".mysqli_real_escape_string($db, $_POST['itemName'])."',
        itemDescription = '".mysqli_real_escape_string($db, $_POST['itemDescription'])."',
        itemPrice = '".mysqli_real_escape_string($db, $itemPrice)."',
        catID = '".mysqli_real_escape_string($db, $_POST['itemCategory'])."',
        itemDescription = '".mysqli_real_escape_string($db, $_POST['itemDescription'])."',
        itemQuantity = '".mysqli_real_escape_string($db, $itemQuantity)."',
        infinity = '".mysqli_real_escape_string($db, $infinity)."',
        itemImage = '".mysqli_real_escape_string($db, $img_src)."'
        WHERE itemID = '".mysqli_real_escape_string($db, $_GET['id'])."'")) {
            $successMsg = 'The changes to the item have been saved.';
    } else {
        $errorMsg .= 'The changes could not be saved to the database.';
    }
}

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$query = mysqli_query($db, "SELECT * FROM invntry_items WHERE itemID = '".$_GET['id']."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);

if ($result == 0) {
    $errorMsg .= 'There is no item with the given item ID.';
} else {
    //$infoMsg .= 'Edit the form fields below and click save. Fields are not mandatory.';


    $tpl->assign('itemName', $row['itemName']);
    $tpl->assign('itemDescription', $row['itemDescription']);
    $tpl->assign('itemPrice', $row['itemPrice']);
    $tpl->assign('itemQuantity', $row['itemQuantity']);
    $tpl->assign('itemInfinity', $row['infinity']);
    $tpl->assign('itemImage', $row['itemImage']);

}

// Fetching category name and ID for the dropdown ///////////
$queryCat = mysqli_query($db, "SELECT * FROM invntry_categories ORDER BY catName ASC") or die(mysqli_error($db));
while ($fetch = mysqli_fetch_assoc($queryCat)) {
            $dataCat[] = array(
                'catID'=>$fetch['catID'],
                'catName'=>$fetch['catName']
            ); 
}
$tpl->assign('dataCat', $dataCat);
$tpl->assign('catID', $row['catID']);

// Fetcing selected item category //////////
$querySel = mysqli_query($db, "SELECT catID, catName FROM invntry_categories WHERE catID = '" . $row['catID'] . "'") or die(mysqli_error($db));
$fetch = mysqli_fetch_assoc($querySel);
$tpl->assign('selectedCatID', $fetch['catID']);
$tpl->assign('selectedCatname', $fetch['catName']);


$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('infoMsg', $infoMsg);
$tpl->assign('page', 'items');
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$html = $tpl->draw('items-edit');
?>