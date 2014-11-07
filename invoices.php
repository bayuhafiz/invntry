<?php 

session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Invoices';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';

function makeSafe($text) 
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == "saved") {
        $successMsg .= 'The invoice has been saved successfully.';
    } elseif($_GET['action'] == "mail") {

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

    } elseif($_GET['action'] == "delete") {
        if (isset($_GET['id'])) {
            if (mysqli_query($db, "UPDATE invntry_invoices SET deleted=1 WHERE invoiceID='".mysqli_real_escape_string($db, $_GET['id'])."'")) {
                $successMsg .= 'The invoice has been deleted successfully.';
            } else {
                $errorMsg .= 'The invoice could not be deleted.';
            }
        } else {
            $errorMsg .= 'No invoice ID has been received. Without a invoice ID the invoice can\'t be deleted.';
        }
    } elseif($_GET['action'] == "send") {
        $successMsg .= 'The invoice <b>'.$_GET['invoicenr'].'</b> has been send to <b>'.$_GET['email'].'</b>.';
    }
}



$query = mysqli_query($db, "SELECT * FROM invntry_invoices WHERE deleted=0 ORDER BY invoiceDate DESC") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

if ($result == 0) {
    $pageContent .= '<p>There are currently no invoices.</p>';
    $invoices = '';
} else {
    $pageContent .= '<p>There are <strong>'.$result.'</strong> invoices.</p>';
    while ($fetch = mysqli_fetch_assoc($query)) {
        if ($fetch['invoiceStatus'] == 0) {
            $invoiceStatus = "Open"; 
        } else {
            $invoiceStatus = "Paid";
        }
        $invoices[] = array(
            'invoiceID'=>$fetch['invoiceID'],
            'invoiceNr'=>$fetch['invoiceNr'],
            'invoiceDate'=>$fetch['invoiceDate'],
            'invoiceDuedate'=>$fetch['invoiceDuedate'],
            'invoiceClient'=>$fetch['invoiceClientName'],
            'invoiceAmount'=> number_format($fetch['invoiceTotal'], 2),
            'invoiceStatus'=>$invoiceStatus,
            'currency' => getCurrency($db, $_SESSION['login_userId']),
        );
    } 
}
    
include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('page', 'invoices');
$tpl->assign('invoices', $invoices);
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$tpl->assign('userFullname', $_SESSION['login_userfname']);

$html = $tpl->draw('invoices');
?>