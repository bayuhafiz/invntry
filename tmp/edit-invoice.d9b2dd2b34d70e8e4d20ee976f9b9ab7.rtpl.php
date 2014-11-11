<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>

<style type="text/css">
        .navbar{
            min-height: 0 !important; 
            margin-bottom: 0 !important; 
        }

        .container{
            box-shadow: 0px 0px 23px #999090;;
            padding-top: 40px;
            padding-bottom: 60px;
        }

    </style>

<script type="text/javascript">
    $(document).ready(function () {
        $("#client").change (function () {
            var text = $("#client option:selected").text();
            var value = $("#client option:selected").val();
        });
    });
</script>
  
 <form method="post" name="invoice-form" id="invoice-form" action="process.php" target="" enctype="multipart/form-data" >
    <input type="hidden" name="invoiceID" value="<?php echo $invoiceID;?>">
    <div class="container" style="padding-bottom: 230px;">
        <div class="row row-centered">
            <div class="col-lg-6" style="display: inline-block;float: none;">
                <img src="resources/templates/../../<?php echo $invoiceLogo;?>" width="40%" style="margin-bottom:20px;" >
                <input type="hidden" name="invoiceLogo" value="<?php echo $invoiceLogo;?>">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" id="address" style="text-align: right;padding-right: 104px;">
                <select id="client" name="client">
                    <option value="">SELECT CLIENT</option>
                    <?php $counter1=-1; if( isset($clients) && is_array($clients) && sizeof($clients) ) foreach( $clients as $key1 => $value1 ){ $counter1++; ?>

                        <?php if( $invoiceClientID==$value1["clientID"] ){ ?>

                        <option value="<?php echo $value1["clientID"];?>" selected><?php echo $value1["clientName"];?></option>
                        <?php }else{ ?>

                        <option value="<?php echo $value1["clientID"];?>"><?php echo $value1["clientName"];?></option>
                        <?php } ?>

                    <?php } ?>

                </select>
                <input type="hidden" id="clientHidden" name="clientID" value="<?php echo $invoiceClientID;?>">

            </div>
        </div>
        <div class="row row-centered">
            <div class="col-lg-6" style="display: inline-block;float: none;font-size: 33px;top: 80px;color:#178cd9">
                <i class="fa fa-chevron-circle-right"></i>
            </div>
        </div>
        <div class="row row-centered" style="margin-bottom:30px;">
            <div class="col-lg-5" style="left: 100px; text-align: left;">
                <h5 class="bold" style="text-transform: uppercase;"><?php echo $userName;?></h5>
                <p><?php echo $userCompany;?></p>
                <p><?php echo $userAddress;?></p>
                <input type="hidden" name="userID" value="<?php echo $userID;?>">
            </div>
             <div class="col-lg-5" id="invoice_address_to" name="invoice_address_to" style="left: 100px;text-align: right;">
                <input type="text" name="invoice_name_to" id="invoice_name_to" class="bold" style="text-align: right;text-transform:uppercase;" disabled="disabled" value="<?php echo $clientNameto;?>"><br />
                <textarea id="invoice_address_to" name="invoice_address_to" rows="7" cols="40" style="text-align:right;resize: none;overflow:hidden;" disabled="disabled"><?php echo $clientAddressto;?>

                </textarea>
            </div>
        </div>
        <div class="row row-centered" style="margin-bottom:30px;">
            <div class="col-lg-5" style="left: 100px;text-align: left;">
                <h2>INVOICE</h2>
                <p>Invoice ID: <?php echo $invoiceNr;?></p>
                <input type="hidden" name="invoiceNr" value="<?php echo $invoiceNr;?>">
                <input type="hidden" name="invoiceID" value="<?php echo $invoiceID;?>">
            </div>
             <div class="col-lg-5" style="left: 100px;top:15px;text-align: right;">
                <h5>Invoice date:
                    <input type="text" name="invoiceDate" value="<?php echo $invoiceDate;?>" id="startDate" class="datepicker" data-date-format="MM dd, yy" style="text-align:right; width:130px;">
                </h5>
                <h5 class="bold">Due date: 
                    <input type="text" name="invoiceDuedate" value="<?php echo $invoiceDuedate;?>" id="endDate"  class="datepicker" data-date-format="MM dd, yyyy" style="text-align:right; width:130px;">
                </h5>
            </div>
        </div>
        <div class="row row-centered">
            <div class="col-lg-10 col-centered">
                <div class="table-responsive">
                    <table class="table table-hover" id="invoice1">
                        <thead>
                            <tr>
                                <th style="border-left:2px solid #178cd9;text-align:left;padding-left:18px;">ITEM</th>
                                <th style="text-align:left;padding-left:18px;">DESCRIPTION</th>
                                <th>PRICE</th>
                                <th>QTY</th>
                                <th>TOTAL</th>
                                <th style="border-right:2px solid #178cd9;width: 102px;">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="editIntovicetb">
                            <input type="hidden" name="itemCounter" class="itemCounter" value="<?php echo $itemCounter;?>">
                            <?php if( $items != '' ){ ?>

                                <?php $counter1=-1; if( isset($items) && is_array($items) && sizeof($items) ) foreach( $items as $key1 => $value1 ){ $counter1++; ?>

                                <tr>
                                    <td>
                                        <!--<select name="itemName[]" data-placeholder="Choose an item..." class="chosen-select" style="width:200px;" tabindex="2">
                                            <option value=""></option>
                                            <option value="<?php echo $value1["itemName"];?>" class="tableItemName" id="tableItemName" selected><?php echo $value1["itemName"];?></option>
                                          </select>-->
                                        <input type="text" name="itemName[]" class="tableItemName" id="tableItemName" value="<?php echo $value1["itemName"];?>" placeholder="item" required>
                                    </td>
                                    <td>
                                        <input type="text" name="itemDescription[]" class="tableItemDescription" id="tableItemDescription" value="<?php echo $value1["itemDescription"];?>" placeholder="description" required>
                                    </td>
                                    <td><input type="text" name="itemPrice[]" id="tableItemPrice" class="itemPrice tableItemPrice" value="<?php echo $value1["itemPrice"];?>" placeholder="0">
                                    </td>
                                    <td>
                                        <input type="text" name="itemQuantity[]" id="tableItemQuantity" class="itemQuantity itemNumeric tableItemQuantity" value="<?php echo $value1["itemQuantity"];?>" placeholder="0">
                                        <i class="validation"></i>
                                        <input type="hidden" value="0" class="counterSuccess">
                                        <input type="hidden" name="hiddenItemQty[]" class="hiddenItemQty" value="<?php echo $value1["hiddenQty"];?>">
                                        <input type="hidden" name="hiddenSavedQty[]" class="hiddenSavedQty" value="<?php echo $value1["itemQuantity"];?>">
                                    </td>
                                    <td>
                                        <span id="tableItemTotal" class="totalItem itemTotal"><?php echo $value1["itemPriceTotal"];?></span>
                                        <input type="hidden" class="totalItem<?php echo $value1["itemID"];?>" name="itemTotal[]" value="<?php echo $value1["itemPriceTotal"];?>" placeholder="0">
                                        
                                    </td>
                                    <td>
                                        <i class="fa fa-trash btn-action remove-invoice"></i>
                                        <input type="hidden" id="tableItemID" name="itemID[]" value="<?php echo $value1["itemID"];?>">
                                        <input type="hidden" name="itemInfinity[]" class="hiddenItemInf" value="<?php echo $value1["infinity"];?>">
                                    </td>
                                </tr>
                                <?php } ?>

                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row row-centered" style="margin-top:40px;margin-bottom:40px;">
            <div class="col-lg-6" style="display:inline-block;float:none;text-align:center;">
                <button type="button" class="btn btn-default btn-more-items" style="border-radius:0;"><i class="fa fa-pencil-square-o"></i> &nbsp;Add More Items</button>
            </div>
        </div>
        <div class="row row-centered">
            <div class="col-lg-3" style="left: 100px;text-align: left;">
                <p>Bank:<br/>
                <?php echo $bankAccount;?></p>
            </div>
            <div class="col-lg-4" style="text-align:right;border-right:1px solid #181818;">
                <h5>SUBTOTAL <?php echo $currency;?> <span id="subTotal" class="subTotal"><?php echo $invoiceSubtotal;?></span></h5>
                <input type="hidden" id="subTotalHidden" class="subTotalHidden" value="" name="subTotal">
                <h5>TAXES/FEES
                    <select class="taxes" name="taxes" id="taxes">
                         <option value="0">Select Tax Rate</option>
                        <?php $counter1=-1; if( isset($taxes) && is_array($taxes) && sizeof($taxes) ) foreach( $taxes as $key1 => $value1 ){ $counter1++; ?>

                            <?php if( $invoiceTaxRate == $value1["taxRate"] ){ ?>

                                <option value="<?php echo $value1["taxRate"];?>" selected><?php echo $value1["taxName"];?> (<?php echo $value1["taxRate"];?>%)</option>
                            <?php }else{ ?>

                                <option value="<?php echo $value1["taxRate"];?>"><?php echo $value1["taxName"];?> (<?php echo $value1["taxRate"];?>%)</option>
                            <?php } ?>

                        <?php } ?>

                    </select> 
                    <?php echo $currency;?> <span class="taxesValue" id="taxValue"> <?php echo $invoiceTax;?></span>
                </h5>
                <input type="hidden" class="taxesValueHidden" id="taxesValueHidden" name="taxesValue" value="<?php echo $invoiceTax;?>">
            </div>
            <div class="col-lg-5" style="top:-15px;padding-right: 108px;text-align: right;color:#178cd9">
                <h1 class="sumItem"><?php echo $currency;?> <span id="sumTotal"><?php echo $invoiceTotal;?></span></h1>
                <input type="hidden" class="sumTotal" id="sumTotalHidden" value="" name="sumTotal">
            </div>
        </div>
        <div class="row" style="margin-top:40px;margin-bottom:50px;" id="action-buttons">
            <div class="col-lg-12" style="text-align: right;padding-right: 116px;">
                <button type="submit" name="Submit" id="subSave" class="btn btn-default" alt="Save invoice to database" value="save-edit"><span class="glyphicon glyphicon-ok-sign"></span> Save invoice</button>
                <button type="submit" name="Submit" id="subMail" class="btn btn-default" alt="Send to client's email" value="mail"><span class="glyphicon glyphicon-envelope"></span> Send to email</button>
                <button type="submit" name="Submit" id="subView" class="btn btn-default" alt="View as PDF" value="view"><span class="glyphicon glyphicon-share"></span> View PDF</button>
            </div>
        </div>
    </div>
</form>

<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>