<?php 
session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Products';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';

if (isset($_GET['action'])) {
    if ($_GET['action'] == "saved") {
        $successMsg .= 'The item has been saved successfully.';
    } elseif($_GET['action'] == "delete") {
        if (isset($_GET['id'])) {
            if (mysqli_query($db, "DELETE FROM invntry_items WHERE itemID='".mysqli_real_escape_string($db, $_GET['id'])."'")) {
                $successMsg .= 'The item has been deleted successfully.';
            } else {
                $errorMsg .= 'The item could not be deleted.';
            }
        } else {
            $errorMsg .= 'No item ID has been received. Without a item ID the item can\'t be deleted.';
        }
    }
}

$query = mysqli_query($db, "SELECT * FROM invntry_items ORDER BY itemId ASC") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

if ($result == 0) {
    $pageContent .= '<p>There are currently no items, start by adding a <a href="items-add.php">new product</a>.</p>';
    $items = '';
} else {
    if ($result == 1) {
        $pageContent .= '<p>There is <strong>'.$result.'</strong> item.</p>';
    }
    else {
        $pageContent .= '<p>There are <strong>'.$result.'</strong> items.</p>';
    }

    while ($fetch = mysqli_fetch_assoc($query)) {
        $fetchCat = mysqli_query($db, "SELECT * FROM invntry_categories WHERE catID = ".$fetch['catID']." LIMIT 1") or die(mysqli_error($db));
        $fetch2 = mysqli_fetch_assoc($fetchCat);

        if ($fetch['infinity'] == "0") {
            $inf = "No";
        }
        else {
            $inf = "Yes";
        }

        $items[] = array(
            'itemID'=>$fetch['itemID'],
            'itemName'=>$fetch['itemName'],
            'itemCategory'=>$fetch2['catName'],
            'itemDescription'=>$fetch['itemDescription'],
            'itemPrice'=> number_format($fetch['itemPrice'],2, '.', ','),
            'itemQuantity'=> $fetch['itemQuantity'],
            'infinity'=> $inf,
            'itemImage'=> $fetch['itemImage']
        );
    }
}
    
include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('page', 'items');
$tpl->assign('items', $items);
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$tpl->assign('currency', getCurrency($db, $_SESSION['login_userId']));

$tpl->assign('userFullname', $_SESSION['login_userfname']);

$html = $tpl->draw('items');
?>