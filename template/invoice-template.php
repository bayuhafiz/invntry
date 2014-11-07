<?php

if (isset($_POST['Submit'])) {

    if (!isset($logo_src)) { $logo_src = ''; }
    if (!isset($address_to)) { $address_to = ''; }
    if (!isset($address_from)) { $address_from = ''; }
    if (!isset($date)) { $date = ''; }
    if (!isset($invoice_nr)) { $invoice_nr = ''; }
    if (!isset($invoice_total_due)) { $invoice_total_due = 0; }
    if (!isset($item_name)) { $item_name = ''; }
    if (!isset($invoice_subtotal)) { $invoice_subtotal = 0; }
    if (!isset($invoice_total_paid)) { $invoice_total_paid = 0; }
    if (!isset($notes)) { $notes = ''; }
    if (!isset($currency)) { $currency = ''; }

    $html = utf8_encode('
            <html>
                <head>
                    <link rel="stylesheet" type="text/css" href="template/css/style.css">
                    <link rel="stylesheet" type="text/css" href="template/css/bootstrap.css">
                    <link rel="stylesheet" type="text/css" href="template/css/font-awesome.min.css">
                    
                </head>
                <body>
                <div class="container">
                    <div class="row row-centered">
                        <div class="col-lg-6" style="display: inline-block;float: none;">
        '); 

    if ($logo_src != '') {
        $html .= utf8_encode ('
                        <img src="'.$logo_src.'" width="25%" style="margin-bottom:60px;" >
            ');
    }

    $html .= utf8_encode ('
                        </div>
                    </div>
                    <div class="row row-centered" style="margin-bottom:30px;">
                        <div class="col-xs-5" style="left: 100px; text-align: left;">
                            '.$address_from.'
                        </div>
                        <div class="col-md-5" name="invoice_address_to" style="text-align: right;">
                            '.$address_to.'
                        </div>
                    </div>
                    <div class="row row-centered" style="margin-bottom:30px;">');

    if ($invoice_nr != '') {
    $html .= utf8_encode ('  
                        <div class="col-xs-5" style="text-align: left;">
                            <h2>INVOICE</h2>                    
                            <p>Invoice #'.$invoice_nr.'</p>
                        </div>');
    }

    $html .= utf8_encode ( '
                        <div class="col-lg-5" style="margin-top:10px;text-align: right;">');

    if ($date != '') {
    $html .= utf8_encode ('
                            <h5>Invoice date: 
                                '.$date.'
                            </h5>');
    }

    if ($due_date != '') {
    $html .= utf8_encode ('
                            <h5 style="font-weight:bold;">Due date: 
                                '.$due_date.'
                            </h5>');
    }
    $html .= utf8_encode ('
                        </div>
                    </div>
                    <div class="row row-centered">
                        <div class="col-lg-10 col-centered">
                            <div class="table-responsive">
                                <table class="table table-hover" id="invoice1">
                                    <thead>
                                        <tr>
                                            <th style="font-weight:normal;border-left:1px solid #178cd9;vertical-align: bottom;border-top: 1px solid #178cd9;border-bottom: 1px solid #178cd9;padding:10px 0 10px 20px;">ITEM</th>
                                            <th style="font-weight:normal;vertical-align: bottom;border-top: 1px solid #178cd9;border-bottom: 1px solid #178cd9;padding:10px 0 10px 25px;">DESCRIPTION</th>
                                            <th style="font-weight:normal;vertical-align: bottom;border-top: 1px solid #178cd9;border-bottom: 1px solid #178cd9;padding:10px 0 10px 0px;">PRICE</th>
                                            <th style="font-weight:normal;vertical-align: bottom;border-top: 1px solid #178cd9;border-bottom: 1px solid #178cd9;text-align: center;padding:10px 0 10px 0px;">QTY</th>
                                            <th style="font-weight:normal;border-right:1px solid #178cd9;width: 102px;vertical-align: bottom;border-top: 1px solid #178cd9;border-bottom: 1px solid #178cd9;text-align:right;padding:10px 20px 10px 0px;">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>');
    if (!empty($item_name)) {
        foreach($item_name as $a => $b) {
            $html .= utf8_encode ('
                                            <tr>
                                                <td style="border-top: 0;padding-bottom: 10px;padding-top: 20px; padding-left:20px;">
                                                    '.makeSafe($item_name[$a]).'
                                                </td>
                                                <td style="border-top: 0;padding-bottom: 10px;padding-top: 20px;">
                                                    '.makeSafe($item_desc[$a]).'
                                                </td>
                                                <td style="border-top: 0;padding-bottom: 10px;padding-top: 20px;">
                                                    '.$currency.' '.makeSafe($item_price[$a]).'
                                                </td>
                                                <td style="border-top: 0;padding-bottom: 10px;padding-top: 20px;text-align:center">
                                                    '.makeSafe($item_qty[$a]).'
                                                </td>
                                                <td class="totalItem itemTotal" style="border-top: 0;padding-bottom: 10px;padding-top: 20px;padding-right:20px;text-align:right">
                                                    '.$currency.' '.makeSafe($item_qty[$a] * $item_price[$a]).'
                                                </td>
                                            </tr>
            ');
        }
    }


    $html .= utf8_encode ('
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row row-centered">
                        <div class="col-xs-3" style="text-align:left;margin-top:50px; padding-top:20px;">
                            <p>Bank:<br/>
                            '. $bank_account .'</p>
                        </div>
                        <div class="col-xs-4" style="padding-top:15px;">
                            <h6>SUBTOTAL '.$currency.' '.$invoice_subtotal.'</h6>
                            <h6>TAXES/FEES '.$invoice_taxrate.' % '.$currency.' '.makeSafe($invoice_subtotal + $invoice_tax - $invoice_subtotal).'</h6>
                        </div>
                        <div class="col-lg-5" style="text-align:right;color:#178cd9;">
                            <h2 class="sumItem" style="font-weight:bold;">'.$currency.''.makeSafe($invoice_subtotal + $invoice_tax).'</h2>
                        </div>
                    </div>

                </div>
                </body>
            </html>
    ');

    }
?>