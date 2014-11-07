<?php 
include_once("config.php");

if (isset($_POST['client'])) {
    if (!empty($_POST['client'])) {
        $clientId = $_POST['client']; // Selected Client Id
    } else {
        $clientId = '';
    }
} else {
    $clientId = '';
}

$invoice_name_to = '';
$invoice_address_to = '';

$query = mysqli_query($db, "SELECT * FROM invntry_clients WHERE clientID='".$clientId."'") or die(mysql_error($db));
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);


if (($row['clientFirstname'] != '') && ($row['clientLastname'] != '')) {
    $clientFullname = $row['clientFirstname'] . " " . $row['clientLastname'];
    $invoice_name_to .= '' . $clientFullname;
} 

if ($row['clientCompany'] != '') {
    $invoice_address_to .= '
    ' . $row['clientCompany'];
} 
if ($row['clientAddress1'] != '') {
    $invoice_address_to .= '
    ' . $row['clientAddress1'] . '';
} 
if ($row['clientAddress2'] != '') {
    $invoice_address_to .= '
    ' . $row['clientAddress2'] . '';
} 
if ($row['clientCity'] != '') {
    $invoice_address_to .= '
    ' . $row['clientCity'] . ' ';
} 
if ($row['clientCountry'] != '') {
    $invoice_address_to .= ', ' . $row['clientCountry'];
} 
if ($row['clientZipcode'] != '') {
    $invoice_address_to .= '
    ' . $row['clientZipcode'];
}

$clientID = $row['clientID'];
$arr = array( 'input#clientID' => $clientID, 'input#invoice_name_to' => $invoice_name_to, 'textarea#invoice_address_to' => $invoice_address_to); 
echo json_encode( $arr );

?>