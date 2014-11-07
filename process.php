<?php 
session_start();
include_once("config.php");
isLoggedin($db);

// converts text to safe output (prevents cross-site-scripting)
function makeSafe($text) 
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// converts linebreaks from textareas to <BR> tags
function lineBreaks($text) 
{ 
    return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />')); 
} 

// generates invoice
function generateInvoice($userID, 
    $clientID, 
    $invoiceID,
    $logo_src, 
    $date, 
    $due_date, 
    $invoice_nr, 
    $infinity,
    $item_id,
    $item_name, 
    $item_qty,
    $hidden_qty,
    $hidden_saved_qty,
    $item_desc, 
    $item_price, 
    $invoice_subtotal, 
    $invoice_taxrate, 
    $invoice_tax, 
    $action, 
    $db, 
    $currency) {

    if ($action == "save") {

  $query = mysqli_query($db, "SELECT * FROM invntry_clients WHERE clientID = '". $clientID ."'") or die(mysqli_error($db));
        $row = mysqli_fetch_assoc($query);

        if ($row['clientCompany'] != '') {
        
            $clientCompany = $row['clientCompany'];
        
        } else {

            $clientCompany = '';
        }

        if (($row['clientFirstname'] != '') or ($row['clientLastname'] != '')) {
            
            $clientName = $row['clientFirstname'].' '.$row['clientLastname']. ' / ' .$clientCompany;
        
        } else {

            $clientName = 'N/A';
        }
        // Save invoice to database
        if(mysqli_query($db, "INSERT INTO invntry_invoices (
        userID,
        invoiceNr,
        invoiceDate,
        invoiceDuedate,
        invoiceSubtotal,
        invoiceTax,
        invoiceTotal,
        invoiceClientID,
        invoiceClientName,
        invoiceLogo,
        invoiceTaxRate
        ) VALUES (
        '".mysqli_real_escape_string($db, $_SESSION['login_userId'])."',
        '".mysqli_real_escape_string($db, $invoice_nr)."',
        '".mysqli_real_escape_string($db, $date)."',
        '".mysqli_real_escape_string($db, $due_date)."',
        '".mysqli_real_escape_string($db, $invoice_subtotal)."',
        '".mysqli_real_escape_String($db, $invoice_tax)."',
        '".mysqli_real_escape_string($db, $invoice_subtotal + $invoice_tax)."',
        '".mysqli_real_escape_string($db, $clientID)."',
        '".mysqli_real_escape_string($db, $clientName)."',
        '".mysqli_real_escape_string($db, $logo_src)."',
        '".mysqli_real_escape_String($db, $invoice_taxrate)."'
        )")) {
        
            header("location: invoices.php?action=saved");
        }
        
        $invoiceID = mysqli_insert_id($db);

        // output each invoice line of items
        if (!empty($item_id)) {
            foreach($item_id as $a => $b) {
                
                mysqli_query($db, "INSERT INTO invntry_invoices_items (
                invoiceID,
                itemID,
                itemName,
                itemDescription,
                itemPrice,
                itemQty,
                itemPriceTotal
                ) VALUES (
                '".$invoiceID."',
                '".mysqli_real_escape_string($db, $item_id[$a])."',
                '".mysqli_real_escape_string($db, $item_name[$a])."',
                '".mysqli_real_escape_string($db, $item_desc[$a])."',
                '".number_format($item_price[$a],2,'.','')."',
                '".mysqli_real_escape_string($db, $item_qty[$a])."',
                '".mysqli_real_escape_string($db, $item_qty[$a] * $item_price[$a])."'
                )") or die(mysqli_error($db));

                $q = mysqli_query($db, "SELECT infinity FROM invntry_items WHERE itemId = '" . $item_id[$a] . "'") or die(mysqli_error($db));
                $i = mysqli_fetch_assoc($q);

                // Reducing inventory quantity when invoice is saved
                if ($i['infinity'] == 0) { // check infinity
                    $new_qty = mysqli_real_escape_string($db, $hidden_qty[$a] - $item_qty[$a]);
                    mysqli_query($db, "UPDATE invntry_items SET itemQuantity = '". $new_qty ."' WHERE itemID = '". mysqli_real_escape_string($db, $item_id[$a]) ."'") or die(mysqli_error($db));
                } 
                
            }
        }
    
        
        
        
        // Insert invoice items into invoice items table
        
    } elseif ($action == "save-edit") {
    
        $clientID = makeSafe($clientID);
        $invoiceID = makeSafe($invoiceID);

        $query = mysqli_query($db, "SELECT clientFirstname, clientLastname, clientCompany FROM invntry_clients WHERE clientID='".mysqli_real_escape_string($db, $clientID)."'") or die(mysqli_error($db));
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        
       if ($row['clientCompany'] != '') {
        
            $clientCompany = $row['clientCompany'];
        
        } else {

            $clientCompany = '';
        }

        if (($row['clientFirstname'] != '') or ($row['clientLastname'] != '')) {
            
            $clientName = $row['clientFirstname'].' '.$row['clientLastname']. ' / ' .$clientCompany;
        
        } else {

            $clientName = 'N/A';
        }

        //echo $invoiceNr;

        // Save invoice to database
        if(mysqli_query($db, "UPDATE invntry_invoices SET
            userID = '".mysqli_real_escape_string($db, $_SESSION['login_userId'])."',
            invoiceNr = '".mysqli_real_escape_string($db, $invoice_nr)."',
            invoiceDate = '".mysqli_real_escape_string($db, $date)."',
            invoiceDuedate = '".mysqli_real_escape_string($db, $due_date)."',
            invoiceSubtotal = '".mysqli_real_escape_string($db, $invoice_subtotal)."',
            invoiceTax = '".mysqli_real_escape_string($db, $invoice_tax)."',
            invoiceTotal = '".mysqli_real_escape_string($db, $invoice_subtotal + $invoice_tax)."',
            invoiceClientID = '".mysqli_real_escape_string($db, $clientID)."',
            invoiceClientName = '".mysqli_real_escape_string($db, $clientName)."',
            invoiceLogo = '".mysqli_real_escape_string($db, $logo_src)."',
            invoiceTaxRate = '".mysqli_real_escape_string($db, $invoice_taxrate)."'

        WHERE invoiceID='".mysqli_real_escape_string($db, $invoiceID)."'")) {
        
            header("location: edit-invoice.php?action=saved&id=".$invoiceID);
        }


        // item's quantity adjusting process
        /* $q1 = mysqli_query($db, "SELECT itemID, itemQty FROM invntry_invoices_items WHERE invoiceID='".mysqli_real_escape_string($db, $invoiceID)."'") or die(mysql_error($db));
        while ($delItem = mysqli_fetch_assoc($q1)) {

            $temp_id = $delItem['itemID'];
            $temp_qty = $delItem['itemQty'];

            $q2 = mysqli_query($db, "SELECT itemQuantity, infinity FROM invntry_items WHERE itemID = '$temp_id'") or die(mysql_error($db));
            $fetch2 = mysqli_fetch_array($q2, MYSQLI_ASSOC);

            if ($fetch2['infinity'] == '0') {

                $inv_qty = $fetch2['itemQuantity'];
                $new_qty = $temp_qty + $inv_qty;
                mysqli_query($db, "UPDATE invntry_items SET itemQuantity = '$new_qty' WHERE itemID = '$temp_id'");

            }
        } */

        // delete current invoice items
        mysqli_query($db, "DELETE FROM invntry_invoices_items WHERE invoiceID='".mysqli_real_escape_string($db, $invoiceID)."'");
        
        // insert invoice items as new 
        if (!empty($item_name)) {
            foreach($item_name as $a => $b) {

                //echo $item_id[$a]."<br/>"; break;
                
                mysqli_query($db, "INSERT INTO invntry_invoices_items (
                invoiceID,
                itemID,
                itemName,
                itemDescription,
                itemPrice,
                itemQty,
                itemPriceTotal
                ) VALUES (
                '".$invoiceID."',
                '".mysqli_real_escape_string($db, $item_id[$a])."',
                '".mysqli_real_escape_string($db, $item_name[$a])."',
                '".mysqli_real_escape_string($db, $item_desc[$a])."',
                '".number_format($item_price[$a],2)."',
                '".mysqli_real_escape_string($db, $item_qty[$a])."',
                '".mysqli_real_escape_string($db, $item_qty[$a] * $item_price[$a])."'
                )") or die(mysqli_error());

                // Adjusting inventory quantity when edited-invoice is saved
                if ($infinity[$a] == '0') { // check infinity

                    if ($item_qty[$a] != $hidden_saved_qty[$a]) {
                        $new_qty[$a] = $hidden_qty[$a] + $hidden_saved_qty[$a] - $item_qty[$a];
                        mysqli_query($db, "UPDATE invntry_items SET itemQuantity = '". $new_qty[$a] ."' WHERE itemID = '". mysqli_real_escape_string($db, $item_id[$a]) ."'") or die(mysqli_error($db));

                    } 

                        
                    
                }
                
            }
        }


        // Do another action
        
    } else {

        // Get user data ($address_from)
        $query = mysqli_query($db, "SELECT userFullname, userCompanyname, userAddress, setBankAccount, userCurrency FROM invntry_users WHERE userID='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'") or die(mysqli_error($db));
        $fetch = mysqli_fetch_array($query, MYSQLI_ASSOC);

        $address_from = "<strong>". $fetch['userFullname'] ."</strong><br/>". $fetch['userCompanyname'] ."<br/>". $fetch['userAddress'];
        $bank_account = $fetch['setBankAccount'];
        $currency = $fetch['userCurrency'];

        // Get client data ($address_to)
        $query = mysqli_query($db, "SELECT * FROM invntry_clients WHERE clientID='".mysqli_real_escape_string($db, $clientID)."'") or die(mysqli_error($db));
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        
        if ($row['clientCompany'] != '') {
            $clientCompany = $row['clientCompany'];
        } else {
            $clientCompany = '';
        }
        if (($row['clientFirstname'] != '') or ($row['clientLastname'] != '')) {
            $clientName = $row['clientFirstname'].' '.$row['clientLastname'];
        } else {
            $clientName = 'N/A';
        }
        $address_to = "<strong>". $clientName ."</strong><br/>". $clientCompany ."<br/>". $row['clientAddress1'] ."<br/>". $row['clientAddress2'] ."<br/>". $row['clientCity'] .", ". $row['clientCountry'] ."<br/>". $row['clientZipcode'];



        // include php invoice templates
        include_once 'template/invoice-template.php';

        if ($invoice_nr != '') {
            $invoice_filename = $invoice_nr . '-invoice.pdf';
        } else {
            $invoice_filename = 'invoice.pdf';
        }


        // include mpdf library
        include_once 'resources/libraries/MPDF57/mpdf.php';
        
        // create new mPDF
        $mpdf = new mPDF(); 
        
        //$mpdf->setFooter('{PAGENO}');
        $mpdf->WriteHTML($html);
        
        if ($action == "view") {

            $mpdf->Output($invoice_filename, 'I');
            unlink('uploads/logos/'.$logo_src.'');

        } elseif ($action == "mail") {

            if (isset($_GET['id'])) {
                $invoiceID = makeSafe($_GET['id']);
            }
            else {
                $invoiceID = makeSafe($_POST['invoiceID']);
            }
            
            $query = mysqli_query($db, "SELECT clientEmailaddress, clientFirstname, clientLastname, clientCompany FROM invntry_clients WHERE clientID='".mysqli_real_escape_string($db, $clientID)."'") or die(mysqli_error($db));
            $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
            
            if (($row['clientFirstname'] != '') or ($row['clientLastname'] != '')) {
            
                $clientName = $row['clientFirstname'].' '.$row['clientLastname'];
            
            } else {

                $clientName = 'N/A';
            }

            $mailToFullname = $clientName;
            $mailTo = $row['clientEmailaddress'];
            if ($row['clientCompany'] != '') {
                $mailToCompany = '('.$row['clientCompany'].')';
            } else {
                $mailToCompany = '';
            }
            
            //header("location: http://www.google.com");
            $mpdf->Output('uploads/invoices/'.$invoice_filename, 'F');
            
            $query = mysqli_query($db, "SELECT setInvoiceAddress, setDefaultName, setDefaultSubject, setDefaultEmail, setDefaultMsg FROM invntry_users WHERE userID='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'") or die(mysqli_error($db));
            $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
            
            
            
            $mailFrom = $row['setDefaultEmail'];
            $mailFromName = $row['setDefaultName'];
            $mailSubject = str_replace("{invoiceNr}", $invoice_nr, $row['setDefaultSubject']);
            $mailSubject = str_replace("{invoiceAmount}", $invoice_total_due, $mailSubject);
            $mailMsg = $row['setDefaultMsg'];
            $mailMsg = str_replace("{invoiceAmount}", $invoice_total_due, $mailMsg);
            $mailMsg = str_replace("{invoiceNr}", $invoice_nr, $mailMsg);
     
            include_once 'resources/libraries/phpMailer/class.phpmailer.php';

            $mail = new PHPMailer();
            $mail->setFrom($mailFrom, $mailFromName);
            $mail->addAddress($mailTo, ''.$mailToFullname.' '.$mailToCompany.'');
            $mail->Subject = $mailSubject;
            $mail->msgHTML($mailMsg);
            $mail->AltBody = $mailMsg;
            $mail->addAttachment('uploads/invoices/'.$invoice_filename.'');

            //send the message, check for errors
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
                echo '<br>';
                echo '<a href="invoices.php">Go back to invoices.</a>';
            } else {
                header("location: invoices.php?action=send&email=".$mailTo."&invoicenr=".$invoice_nr."");
            }


        } elseif ($action == "download") {
            $mpdf->Output($invoice_filename, 'D');
            unlink('uploads/logos/'.$logo_src.'');
        }
        
        exit;  
    
    } 
} 

// invoice form has been submitted
if (isset ($_POST['Submit'])) {
    
    // save all data input as variable and use makeSafe to prevent xss
    $userID             = makeSafe($_POST['userID']);
    $clientID           = makeSafe($_POST['clientID']);

    if (isset ($_POST['invoiceID'])) {
        $invoiceID      = $_POST['invoiceID'];
    }
    else {
        $invoiceID      = '';
    }

    $logo_src           = makeSafe($_POST['invoiceLogo']);
    $date               = makeSafe($_POST['invoiceDate']);
    $due_date           = makeSafe($_POST['invoiceDuedate']);
    $invoice_nr         = makeSafe($_POST['invoiceNr']);

    $item_id            = $_POST['itemID'];
    $item_name          = $_POST['itemName'];
    $item_qty           = $_POST['itemQuantity'];
    $item_price         = $_POST['itemPrice'];
    $item_desc          = $_POST['itemDescription'];
    $hidden_qty         = $_POST['hiddenItemQty'];


    if (isset ($_POST['itemInfinity'])) {
        $infinity       = $_POST['itemInfinity'];
    }
    else {
        $infinity      = '';
    }

    if (isset ($_POST['hiddenSavedQty'])) {
        $hidden_saved_qty      = $_POST['hiddenSavedQty'];
    }
    else {
        $hidden_saved_qty      = '';
    }

    $invoice_subtotal   = makeSafe($_POST['subTotal']);
    $invoice_taxrate    = makeSafe($_POST['taxes']);
    $invoice_tax        = ($invoice_taxrate/100)*$invoice_subtotal;
    $action             = makeSafe($_POST['Submit']);
    $currency           = getCurrency($db, $_SESSION['login_userId']);

    
    
    // Create the invoice
    generateInvoice($userID, $clientID, $invoiceID, $logo_src, $date, $due_date, $invoice_nr, $infinity, $item_id, $item_name, $item_qty, $hidden_qty, $hidden_saved_qty, $item_desc, $item_price, $invoice_subtotal, $invoice_taxrate, $invoice_tax, $action, $db, $currency); 
}

?>