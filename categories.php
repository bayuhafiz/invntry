<?php 


session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Categories';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';

if (isset($_GET['action'])) {
    if ($_GET['action'] == "saved") {
        $successMsg .= 'The category item category has been saved successfully.';
    } elseif($_GET['action'] == "delete") {
        if (isset($_GET['id'])) {
            if (mysqli_query($db, "DELETE FROM invntry_categories WHERE catID='".mysqli_real_escape_string($db, $_GET['id'])."'")) {
                $successMsg .= 'The item category has been deleted successfully.';
            } else {
                $errorMsg .= 'The item category could not be deleted.';
            }
        } else {
            $errorMsg .= 'No category ID has been received. Without a category ID the category can\'t be deleted.';
        }
    }
}

$query = mysqli_query($db, "SELECT * FROM invntry_categories ORDER BY catID DESC") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

if ($result == 0) {
    $pageContent .= '<p>There are currently no categories, start by adding a <a href="category-add.php">new category</a>.</p>';
    $categories = '';
} else {
    if ($result == 1) {
        $pageContent .= '<p>There is <strong>'.$result.'</strong> category.</p>';
    }
    else {    
        $pageContent .= '<p>There are <strong>'.$result.'</strong> categories.</p>';
    }
        
        while ($fetch = mysqli_fetch_assoc($query)) {
            $categories[] = array(
                'catID'=>$fetch['catID'],
                'catName'=>$fetch['catName'],
                'catDescription'=>$fetch['catDescription'],
            );
        }    
}
    
include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('page', 'categories');
$tpl->assign('categories', $categories);
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$tpl->assign('userFullname', $_SESSION['login_userfname']);

$html = $tpl->draw('categories');
?>