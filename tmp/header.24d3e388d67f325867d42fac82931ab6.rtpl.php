<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE HTML>

<html>

<head>

    <meta http-equiv="Content-type" value="text/html; charset=UTF-8" />
    
    <title><?php echo $pageTitle;?> - Invntry &trade;</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="resources/templates/./assets/css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="resources/templates/./assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="resources/templates/./assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="resources/templates/./assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="resources/templates/./assets/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="resources/templates/./assets/plugins/bootstrap-datepicker/datepicker.css">
    <link rel="stylesheet" type="text/css" href="resources/templates/./assets/css/lightbox.css"/>
    <link rel="stylesheet" type="text/css" href="resources/templates/./assets/css/chosen.css">
        
    <script type="text/javascript" src="resources/templates/./assets/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="resources/templates/./assets/js/chosen.jquery.js"></script>
    <script type="text/javascript" src="resources/templates/./assets/js/lightbox.min.js"></script>    
    <script type="text/javascript" src="resources/templates/./assets/js/jquery-ui.js"></script>
    <script type="text/javascript" src="resources/templates/./assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="resources/templates/./assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="resources/templates/./assets/js/jquery.confirm.js"></script>
    <script type="text/javascript" src="resources/templates/./assets/js/jquery.formatCurrency-1.4.0.min.js"></script>
    <script type="text/javascript" src="resources/templates/./assets/js/dmuploader.min.js"></script>
    
    <script type="text/javascript">

        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////// INVOICE FUNCTIONS SECTION /////////////////////////
        ////////////////////////////////////////////////////////////////////////////////

        function addCommas(n) {
            return(n.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        }

        function removeCommas(n)
        {
           return(n.replace(/,/g,''));
        }


        function countItemTotal(n,m) {
            var a = removeCommas(n), 
                b = removeCommas(m);

            var total = parseFloat(a*b);
            var totalVal = addCommas(total);

            //document.getElementById('tableItemTotal').innerHTML = totalVal;
            //document.getElementById('hiddenItemTotal').value = total;

            return totalVal;
        }


        function countSubTotal() {
            var sum = 0;

            $(".itemTotal").each(function() {

                var value = removeCommas($(this).text());
                if(!isNaN(value) && value.length != 0) {
                    sum += parseFloat(value);
                }

            })

            var subTotalVal = addCommas(sum);
  

            document.getElementById('subTotal').innerHTML = subTotalVal;
            document.getElementById('subTotalHidden').value = sum;
        }


        function countTax() {
            var rateSelected  = document.getElementById('taxes').value;
            if (rateSelected != '0') {
              var rateSelectedVal = parseFloat(rateSelected);
            } else {
              var rateSelectedVal = 0;
            }
            
            var subTotal = document.getElementById('subTotal').innerHTML;
            if (subTotal != '0') {
              var subTotalVal = parseFloat(removeCommas(subTotal));
            } else {
              var subTotalVal = 0;
            }
            

            var taxesTotal = ( rateSelected / 100 ) * subTotalVal;
            var taxesTotalVal = addCommas(taxesTotal);

            document.getElementById('taxValue').innerHTML = taxesTotalVal;
            document.getElementById('taxesValueHidden').value = taxesTotal;
        }


        function countTotal() {
            var subTotal = document.getElementById('subTotal').innerHTML;
            if (subTotal != '0') {
              var subTotalVal = parseFloat(removeCommas(subTotal));
            } else {
              var subTotalVal = 0;
            }
            var taxValue = document.getElementById('taxValue').innerHTML;
            if ( taxValue != '0') {
              var taxValuVal = parseFloat(removeCommas(taxValue));
            } else {
              var taxValuVal = 0;
            }

            var sumTotal = subTotalVal + taxValuVal;
            var sumTotalVal = addCommas(sumTotal);

            document.getElementById('sumTotal').innerHTML = sumTotalVal;
            document.getElementById('sumTotalHidden').value = sumTotal;
        }

        function disabledKey() {
           
            $(".itemNumeric").keydown(function(event) {
        
                if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 ) {

                } else {
        
                    if (event.keyCode < 48 || event.keyCode > 57 ) {
                        event.preventDefault(); 
                    }   
                }
            });
        }

        function decimalPlace() {
          
            $('.itemPrice').blur(function() {
                $('.itemPrice').html(null);
                $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: 2, symbol: '' });
            })
            .keyup(function(e) {
                var e = window.event || e;
                var keyUnicode = e.charCode || e.keyCode;
                if (e !== undefined) {
                    switch (keyUnicode) {
                        case 16: break; // Shift
                        case 17: break; // Ctrl
                        case 18: break; // Alt
                        case 27: this.value = ''; break; // Esc: clear entry
                        case 35: break; // End
                        case 36: break; // Home
                        case 37: break; // cursor left
                        case 38: break; // cursor up
                        case 39: break; // cursor right
                        case 40: break; // cursor down
                        case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
                        case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
                        case 190: break; // .
                        default: $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: -1, eventOnDecimalsEntered: true, symbol: '' });
                    }
                }
            })
            .bind('decimalsEntered', function(e, cents) {
                if (String(cents).length > 2) {
                    $('button.saveItemAdd, button.saveItemAddMore, button.saveItemEdit').attr('disabled', true);
                    var errorMsg = 'Please do not enter any cents (0.' + cents + ')';
                    $('#itemPriceMsg').html(errorMsg);
                    log('Event on decimals entered: ' + errorMsg);
                    
                } else {
                    $('button.saveItemAdd, button.saveItemAddMore, button.saveItemEdit').attr('disabled', false);
                    var errorMsg = '';
                    $('#itemPriceMsg').html(errorMsg);
                    log('Event on decimals entered: ' + errorMsg);
                    
                }
            });
        }

        function validationQuantity() {
          //// Quantity validation quantity ////

          $('input#tableItemQuantity').keyup( function (event) {

            var thisItem = $(this);
            var tbody = thisItem.parent().parent().parent();
            var tbodyCreate = thisItem.parent().parent().parent('.createIntovicetb');
            var tbodyEdit = thisItem.parent().parent().parent('.editIntovicetb');
            
        
                if(tbody.hasClass('createIntovicetb')){
        
                    var $itemQty = parseInt(thisItem.parent().parent().children().children('#tableItemQuantity').val());
                    var $id = parseInt(thisItem.parent().parent().children().children('.hiddenItemQty').val());
                    var $inf = parseInt(thisItem.parent().parent().children().children('.hiddenItemInf').val());
                
                                var template ='';

                                if ($inf == 0) {
                                     if ($itemQty <= $id) {
                                        template = "<i class=\'fa fa-check\' style=\'color:green\'></i>";
                                    } else {
                                        template = "<i class=\'fa fa-exclamation-circle\' style=\'color:red\'></i>";
                                    }
                                } else if($inf == 1) {
                                    template = "";
                                }

                } else if(tbody.hasClass('editIntovicetb')){
              

                    var $itemQty = parseInt(thisItem.parent().parent().children().children('#tableItemQuantity').val());
                    var $id = parseInt(thisItem.parent().parent().children().children('.hiddenItemQty').val());
                    var $inf = parseInt(thisItem.parent().parent().children().children('.hiddenItemInf').val());
                    var $savedQty = parseInt(thisItem.parent().parent().children().children('.hiddenSavedQty').val());
                    
                                var template ='';

                                if ($inf == 0) {
                                     if ($itemQty <= $id + $savedQty) {
                                        template = "<i class=\'fa fa-check\' style=\'color:green\'></i>";
                                    } else {
                                        template = "<i class=\'fa fa-exclamation-circle\' style=\'color:red\'></i>";
                                    }
                                } else if($inf == 1) {
                                    template = "";
                                }

                }


                thisItem.parent().parent().children().children('i.validation').html(template);

                var wrapperSuccess = $('.table tbody').find('i.validation i.fa-check').length;
                var wrapperError = $('.table tbody').find('i.validation i.fa-exclamation-circle').length;

                if (wrapperSuccess > 0) {
                  $('#subSave').attr('disabled', false);
                } 

                if (wrapperError > 0 ) {
                  $('#subSave').attr('disabled', true);
                } 
          
          });
        }



    </script>


    
    <style type="text/css">
      .dataTables_filter, 
      .dataTables_length, 
      .dataTables_info, 
      .bg-modal-product, 
      .bg-modal-editProduct, 
      .bg-modal-client,
      .bg-modal-editClient,
      .bg-modal-addCategory {
        display: none;
      }

      .dataTables_wrapper .dataTables_paginate {
        float: none;
        text-align: center;
        padding-top: 2.25em;
      }

      .table > tbody > tr.active > td{
        background-color: #eff6fe;
        color: #178cd9;
      }

      .table > tbody > tr.active > td.borderLeft{
        border-left: 3px solid #178cd9;
      }

      .table-hover > tbody > tr > td.active:hover,
      .table-hover > tbody > tr > th.active:hover,
      .table-hover > tbody > tr.active:hover > td,
      .table-hover > tbody > tr:hover > .active,
      .table-hover > tbody > tr.active:hover > th {
        background-color: #eff6fe;
      }

      .navbar-default .navbar-nav > .open > a,
      .navbar-default .navbar-nav > .open > a:hover, 
      .navbar-default .navbar-nav > .open > a:focus {
        height: 53px;
      }

      .paginate_button.previous.disabled{
        color: red;
      }
      
      .ui-widget-header {
        border: 1px solid #FFFFFF;
        background: #FFF;
        color: #000000;
        font-weight: bold;
      }

      .ui-widget-content {
        border: 1px solid #dddddd;
        background: #FFF;
        color: #333333;
      }

      .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
        color: #000; 
      }

      .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
        border: 0;
        background:#FFF;
      }



    </style>

</head>

<body>

  


  <nav class="navbar navbar-default" role="navigation" style="border-radius: 0;border-left: 0;border-right: 0;background-color:#FFF;margin-bottom: 70px;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 centered-div">

          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="font-size:35px;color:#2d7fb9" href="./">invntry&nbsp;&trade;</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li <?php if( $page == 'items' ){ ?>class="active"<?php } ?>><a href="items.php">Inventory</a></li>
              <li <?php if( $page == 'clients' ){ ?>class="active"<?php } ?>><a href="clients.php">Clients</a></li>
              <li <?php if( $page == 'invoices' ){ ?>class="active"<?php } ?>><a href="invoices.php">Invoices</a></li>
              <li class="dropdown <?php if( $page == 'settings' ){ ?>active<?php } ?> <?php if( $page == 'categories' ){ ?>active<?php } ?> <?php if( $page == 'taxes' ){ ?>active<?php } ?>" >
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings&nbsp;&nbsp;<i class="fa fa-angle-down" style="width: 16px;height: 16px;border: 1px solid #178cd9;border-radius: 50%;text-align:center;color:#178cd9;"></i> </a>
                <ul class="dropdown-menu">
                  <li><a href="categories.php">Category</a></li>
                  <li><a href="settings.php">Invoice</a></li>
                  <li><a href="taxes.php">Taxes</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><?php echo $userFullname;?>&nbsp;&nbsp;</b><i class="fa fa-angle-down" style="width: 16px;height: 16px;border: 1px solid #178cd9;border-radius: 50%;text-align:center;color:#178cd9;"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="login.php?logout=1">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div><!-- /.navbar-collapse -->

        </div>
      </div>   
    </div><!-- /.container-fluid -->
  </nav>



 
 
