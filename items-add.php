<?php 
session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Add product';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';

if (isset($_GET['action'])) {
    if ($_GET['action'] == "saved") {
        $successMsg .= 'The item has been saved successfully. Fill the fields below to add another item.';
    } 
}

if (isset($_POST['Save'])) {
  if ((empty($_POST['itemName'])) or (empty($_POST['itemDescription'])) or (empty($_POST['itemCategory'])) or (empty($_POST['itemPrice'])) ) {
        $errorMsg .= 'Fields cannot be empty!';
  } else {
    
    $itemPrice = str_replace(",", "", $_POST['itemPrice']);
    $itemPrice = number_format($itemPrice, 2, '.', '');

    // Get the infinity radio button value
    $infinity = $_POST['infinity'];
    if ($infinity == '1') {
        $itemQuantity = 1;
    } else {
        $itemQuantity = mysqli_real_escape_string($db, $_POST['itemQuantity']);
    }

    ////////////////////////////////////////
    //////// Item image processing /////////
    ////////////////////////////////////////

    $upload_dir = 'uploads/items/';
    $key = rand(00000, 99999) . '_';
    $img_src = '';
        
            if(move_uploaded_file($_FILES['itemImage']['tmp_name'], $upload_dir . $key . $_FILES['itemImage']['name'])) {
                $img_src = $upload_dir . $key .  $_FILES['itemImage']['name'];
            } else {  
                $img_src = '';
                $errorMsg .= 'Item image could not be uploaded, please try again.';
            }

    //echo $_POST['itemPrice']; break;

    if(mysqli_query($db, "INSERT INTO invntry_items (
        userID,
        itemName,
        catID,
        itemDescription,
        itemPrice,
        itemQuantity,
        infinity,
        itemImage
        ) VALUES (
        '".mysqli_real_escape_String($db, $_SESSION['login_userId'])."',
        '".mysqli_real_escape_string($db, $_POST['itemName'])."',
        '".mysqli_real_escape_string($db, $_POST['itemCategory'])."',
        '".mysqli_real_escape_string($db, $_POST['itemDescription'])."',
        '".mysqli_real_escape_string($db, $_POST['itemPrice'])."',
        '".mysqli_real_escape_string($db, $itemQuantity)."',
        '".mysqli_real_escape_string($db, $infinity)."',
        '".mysqli_real_escape_string($db, $img_src)."'
        )")) {
        
        header("location: items.php?action=saved");
    
    } else {
        $errorMsg .= 'The item could not be saved to the database.';
    }
  }
}

if (isset($_POST['SaveAdd'])) {
    if ((empty($_POST['itemName'])) or (empty($_POST['itemDescription'])) or (empty($_POST['itemCategory'])) ) {
        $errorMsg .= 'Fields cannot be empty!';
  } else {

    if (empty($_POST['itemPrice'])) {
        $itemPrice = 0;
    } else {
        $itemPrice = $_POST['itemPrice'];
    }
    
    $itemPrice = str_replace(",", "", $itemPrice);
    $itemPrice = number_format($itemPrice, 2, '.', '');

    // Get the infinity radio button value

    $infinity = $_POST['infinity'];
    if ($infinity == '1') {
        $itemQuantity = 1;
    } elseif ($infinity == '0') {
        $itemQuantity = mysqli_real_escape_string($db, $_POST['itemQuantity']);
    }

    // Item image processing
    $upload_dir = 'uploads/items/';
    $key = rand(00000, 99999) . '_';
    $img_src = "";
        
        // Check if itemImage filetype is GIF, JPG, JPEG or PNG
        //$ext = pathinfo($_FILE['itemImage']['name'], PATHINFO_EXTENSION);
        //$allowed = array('jpg','png','gif','jpeg');
        if ($_FILES['itemImage']['name'] == '') {
            $img_src = '';
        } else {
            if(move_uploaded_file($_FILES['itemImage']['tmp_name'], $upload_dir . $key . $_FILES['itemImage']['name'])) {
                $img_src = $upload_dir . $key .  $_FILES['itemImage']['name'];
            } else {  
                $img_src = '';
                $errorMsg .= 'Item image could not be uploaded, please try again.';
            }
        }
    
    if(mysqli_query($db, "INSERT INTO invntry_items (
        userID,
        itemName,
        catID,
        itemDescription,
        itemPrice,
        itemQuantity,
        infinity,
        itemImage
        ) VALUES (
        '".mysqli_real_escape_String($db, $_SESSION['login_userId'])."',
        '".mysqli_real_escape_string($db, $_POST['itemName'])."',
        '".mysqli_real_escape_string($db, $_POST['itemCategory'])."',
        '".mysqli_real_escape_string($db, $_POST['itemDescription'])."',
        '".mysqli_real_escape_string($db, $itemPrice)."',
        '".mysqli_real_escape_string($db, $itemQuantity)."',
        '".mysqli_real_escape_string($db, $infinity)."',
        '".mysqli_real_escape_string($db, $img_src)."'
        )")) {
        
        header("location: items-add.php?action=saved");
    
    } else {
        $errorMsg .= 'The item could not be saved to the database.';
    }
  }
}

//$infoMsg .= 'Fill out the form fields below to add a new item. All fields are mandatory.';

// Fetching category name and ID for the dropdown
$queryCat = mysqli_query($db, "SELECT * FROM invntry_categories ORDER BY catName ASC") or die(mysqli_error($db));
while ($fetch = mysqli_fetch_assoc($queryCat)) {
            $dataCat[] = array(
                'catID'=>$fetch['catID'],
                'catName'=>$fetch['catName']
            ); 
}

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
//$tpl->assign('infoMsg', $infoMsg);
$tpl->assign('page', 'items');
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$tpl->assign('dataCat', $dataCat);

$tpl->assign('currency', getCurrency($db, $_SESSION['login_userId']));

$html = $tpl->draw('items-add');
?>