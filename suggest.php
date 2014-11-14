<?php
	include_once("config.php");
 
	$company    = $_GET['company'];
 
	$sql        = "SELECT itemName FROM invntry_items WHERE itemName like '$company%' ORDER BY itemName";
 
	$res        = $db->query($sql);
 
	if(!$res)
		echo mysqli_error($db);
	else
		while( $row = $res->fetch_object() )
			echo "<option value='".$row->itemName."'></option>";
 
?>