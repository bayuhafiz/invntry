<?php

	 include("config.php");
	
    $itemID = $_POST['itemID'];
    $invoiceID = $_POST['invoiceID'];

    // Fetch saved item's quantity
    $q1 = mysqli_query($db, "SELECT itemQty FROM invntry_invoices_items WHERE itemID = '$itemID' AND invoiceID = '$invoiceID'") or die(mysql_error($db));
    $fetch1 = mysqli_fetch_array($q1, MYSQLI_ASSOC);
    $temp_qty = $fetch1['itemQty'];

    // Delete invoice item record
    $q2 = mysqli_query($db, "DELETE FROM invntry_invoices_items WHERE itemID = '$itemID' AND invoiceID = '$invoiceID'") or die(mysql_error($db));

    // Fetch inventory item's qty
    $q3 = mysqli_query($db, "SELECT itemQuantity FROM invntry_items WHERE itemID = '$itemID'") or die(mysql_error($db));
    $fetch3 = mysqli_fetch_array($q3, MYSQLI_ASSOC);
    $inv_qty = $fetch3['itemQuantity'];

    // Calculating new inventory item's quantity
    $new_qty = mysqli_real_escape_string($db, $temp_qty + $inv_qty);
    
    // Pushing to DB
    if (mysqli_query($db, "UPDATE invntry_items SET itemQuantity = '$new_qty' WHERE itemID = '$itemID'")) {
      return true;
    } else {
      return false;
    }

?>