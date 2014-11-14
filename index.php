<?php 
session_start();
include_once("config.php");
if (isLoggedin($db)) {
	header("location: items.php");
}
else {
	header("location: login.php");
}
?>