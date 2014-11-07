<?php 
session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Edit category';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';
$infoMsg      = '';

if (isset($_POST['Submit'])) {
    if(mysqli_query($db, "UPDATE invntry_categories SET
        catName = '".mysqli_real_escape_string($db, $_POST['catName'])."',
        catDescription = '".mysqli_real_escape_string($db, $_POST['catDescription'])."'
        WHERE catID = '".mysqli_real_escape_string($db, $_GET['id'])."'")) {
            $successMsg = 'The changes to the category have been saved.';
    } else {
        $errorMsg .= 'The changes could not be saved to the database.';
    }
}

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$query = mysqli_query($db, "SELECT * FROM invntry_categories WHERE catID='".mysqli_real_escape_string($db, $_GET['id'])."' AND userID='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);

if ($result == 0) {
    $errorMsg .= 'There is no category with the given category ID.';
} else {
    $infoMsg .= 'Edit the form fields below and click save. Fields are not mandatory.';

    $tpl->assign('catName', $row['catName']);
    $tpl->assign('catDescription', $row['catDescription']);
}

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('infoMsg', $infoMsg);
$tpl->assign('page', 'categories');
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$tpl->assign('userFullname', $_SESSION['login_userfname']);

$html = $tpl->draw('category-edit');
?>