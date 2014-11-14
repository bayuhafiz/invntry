<?php 


session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle = 'Taxes';
$pageContent = '';
$errorMsg = '';
$successMsg = '';

if (isset($_GET['action'])) {
    if ($_GET['action'] == "saved") {
        $successMsg .= 'The taxrate has been saved successfully.';
    } elseif($_GET['action'] == "delete") {
        if (isset($_GET['id'])) {
            if (mysqli_query($db, "DELETE FROM invntry_taxes WHERE taxID='".mysqli_real_escape_string($db, $_GET['id'])."'")) {
                $successMsg .= 'The taxrate has been deleted successfully.';
            } else {
                $errorMsg .= 'The taxrate could not be deleted.';
            }
        } else {
            $errorMsg .= 'No tax ID has been received. Without a tax ID the taxrate can\'t be deleted.';
        }
    }
}

$query = mysqli_query($db, "SELECT * FROM invntry_taxes WHERE userID='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."' ORDER BY taxRate DESC") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

if ($result == 0) {
    $pageContent .= '<p>There are currently no taxrates.</p>';
    $taxes = '';
} else {
    $pageContent .= '<p>There are <strong>'.$result.'</strong> taxrates.</p>';
    while ($fetch = mysqli_fetch_assoc($query)) {
        $taxes[] = array(
            'taxID'=>$fetch['taxID'],
            'taxName'=>$fetch['taxName'],
            'taxRate'=>$fetch['taxRate'],
            );
    }
}
    
include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('page', 'taxes');
$tpl->assign('taxes', $taxes);
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$tpl->assign('userFullname', $_SESSION['login_userfname']);
$html = $tpl->draw('taxes');
?>