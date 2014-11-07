<?php
	 include("config.php");
	
    $itemQty = $_POST['itemQty'];

    //$query = mysqli_query($db, "SELECT * FROM invntry_items WHERE itemID = '$id'") or die(mysql_error($db));
    //$fetch = mysqli_fetch_array($query, MYSQLI_ASSOC);

    header('Content-Type:application/json');

    echo json_encode(
      array(
        'quantity' => $itemQty
      )
    );

?>