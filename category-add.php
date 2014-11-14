<?php 
session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Add category';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';
$infoMsg      = '';

if (isset($_GET['action'])) {
    if ($_GET['action'] == "saved") {
        $successMsg .= 'The category has been saved successfully. Fill the fields below to add another category.';
    } 
}

if (isset($_POST['Save'])) {
    
    if(mysqli_query($db, "INSERT INTO invntry_categories (
        userID,
        catName,
        catDescription
        ) VALUES (
        '".mysqli_real_escape_String($db, $_SESSION['login_userId'])."',
        '".mysqli_real_escape_string($db, $_POST['catName'])."',
        '".mysqli_real_escape_string($db, $_POST['catDescription'])."'
        )")) {
        

        header("location: categories.php?action=saved");
    } else {
        $errorMsg .= 'The category could not be saved to the database.';
    }

} else if (isset($_POST['SaveAdd'])) {
    
    if(mysqli_query($db, "INSERT INTO invntry_categories (
        userID,
        catName,
        catDescription
        ) VALUES (
        '".mysqli_real_escape_String($db, $_SESSION['login_userId'])."',
        '".mysqli_real_escape_string($db, $_POST['catName'])."',
        '".mysqli_real_escape_string($db, $_POST['catDescription'])."'
        )")) {
        
        
        header("location: category-add.php?action=saved");
    } else {
        $errorMsg .= 'The category could not be saved to the database.';
    }
}

$infoMsg .= 'Fill out the form fields below to add a new category. Fields are mandatory.';

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('infoMsg', $infoMsg);
$tpl->assign('page', 'categories');
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$tpl->assign('userFullname', $_SESSION['login_userfname']);

$html = $tpl->draw('category-add');
?>