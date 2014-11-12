<?php if(!class_exists('raintpl')){exit;}?>    </div>
    <div class="footer">
        <p style="font-size:25px;color:#2d7fb9;text-align:center;padding-top:17px;" href="#">invntry&nbsp;&trade;</p>
        <div style="float:right;position:relative;top: -26px; right:250px;"><a href="#">contact@invtry.co</a> &nbsp;&nbsp;&nbsp;&nbsp; <a href="#">SUPPORT</a></div>
    </div>

  

<script type="text/javascript">

    

    $(document).ready(function() {

        disabledKey();

        decimalPlace();

        validationQuantity();

        var ac_config = { 
            source: "ajaxItems.php", 
            select: function(event, ui){ 
                
                    var newItemName = $(this).parent().parent().children().children("input.tableItemName").val(ui.item.name);
                    var newItemDesc = $(this).parent().parent().children().children("input.tableItemDescription").val(ui.item.desc); 
                    var newItemPrice = $(this).parent().parent().children().children("input.tableItemPrice").val(ui.item.price);
                    var newItemQty = $(this).parent().parent().children().children("input.tableItemQuantity").val(ui.item.qty);
                    var newItemID = $(this).parent().parent().children().children("input.hiddenItemID").val(ui.item.id);
                    var newHiddenItemInf = $(this).parent().parent().children().children("input.hiddenItemInf").val(ui.item.inf); 


                    $(this).parent().parent().children().children("input.tableItemName").attr('value', newItemName.val());
                    $(this).parent().parent().children().children("input.tableItemDescription").attr('value', newItemDesc.val());
                    $(this).parent().parent().children().children("input.tableItemPrice").attr('value', newItemPrice.val());
                    $(this).parent().parent().children().children("input.tableItemQuantity").attr('value', newItemQty.val());
                    $(this).parent().parent().children().children("input.hiddenItemInf").attr('value', newHiddenItemInf.val());



                    $(this).parent().parent().children().children("input.hiddenItemID").attr('value', newItemID.val());
                    $(this).parent().parent().children().children("input.hiddenItemQty").attr('value', newItemQty.val());


                    /// itemTotal //
                    var itemPrice = $(this).parent().parent().children().children('.itemPrice').val();
                    var itemQuantity = $(this).parent().parent().children().children('.itemQuantity').val();

                    var total = countItemTotal(itemPrice,itemQuantity);

                    var totalItem = $(this).parent().parent().children().children('#tableItemTotal').text(total);


                    /// subTotal ///
                    countSubTotal();

                    countTax();
                    countTotal();


            }, 
            minLength:1 
        }; 

        ////////// Chosen /////////////

        var config = {
          '.chosen-select'           : {},
          '.chosen-select-deselect'  : {allow_single_deselect:true},
          '.chosen-select-no-single' : {disable_search_threshold:10},
          '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
          '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
          $(selector).chosen(config[selector]);
        }

        ////// End Chosen ////////

        
        $(".tableItemName").autocomplete(ac_config);

        $('.fa-search').tooltip();

     
        $("#endDate").datepicker({});
        $("#startDate").datepicker({
            onSelect: function (dateText, inst) {
                var date = $.datepicker.parseDate($.datepicker._defaults.dateFormat, dateText);
                $("#endDate").datepicker("option", "minDate", date);
                $("#endDate").datepicker("setDate", date);
                $('#startDate, #endDate').datepicker('option', 'dateFormat','MM d, yy');
            }
        });


        /////////////////// Client dropdown /////////


        $("#client").change (function () {
            var text = $("#client option:selected").text();
            var value = $("#client option:selected").val();
        });

        $('#client').change(function(event) {
            $.ajax({
                url     : 'ajaxClients.php',
                type    : 'POST',
                dataType: 'json',
                data    : $('#invoice-form').serialize(),
                success: function( data ) {
                       for(var id in data) {        
                              $(id).val( data[id] );
                       }
                }
            });

            var valueClient = $(this).val();

            $('#clientHidden').val(valueClient);
        });


        ////////////////// Fetch items array ///////// 
        $('#tableItemName').change(function(event) {
            $.ajax({
                url     : 'ajaxItems.php',
                type    : 'POST',
                dataType: 'json',
                data    : $('#invoice-form').serialize(),
                success: function( data ) {
                       for(var id in data) {        
                              $(id).val( data[id] );
                       }
                }
            });
        });


        /////////////// disabled button No and Yes Quantity /////
        $('#no-infinity').click(function () {
            $('#itemQuantity').attr('disabled', false);
        })

        $('#yes-infinity').click(function () {
            $('#itemQuantity').attr('disabled', true);
            $('#itemQuantity').val(1);
        })


        //////////////// fade in modal //////////////

        $('div.bg-modal-product , div.bg-modal-editProduct, div.bg-modal-client , div.bg-modal-editClient , div.bg-modal-addCategory').fadeIn(500);


        /////////// checked function /////////////
        var checkedCount = $('input:checkbox:checked').length;


       
        $('.table').on("click", 'tbody tr', function (event) {

            var target = $(event.target),checkbox;

            if (target.is('input:checkbox')) {
                // return; // jangan return disini, lanjutkan untuk modifikasi checkedCount
                checkbox = target;

            } else {
                checkbox = $(this).find('input:checkbox');
                checkbox.prop("checked", !checkbox.is(':checked'));
            }
            // tambahkan ato kurangi checkedCount tergantung pada kondisi checked
            checkedCount += (checkbox.is(':checked')) ? 1 : -1;

            // gunakan checkedCount untuk menentukan disabled
            $('.btn-create-order').prop('disabled', checkedCount == 0);
      

            if (checkbox.is(':checked')) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });


        if ($('input:checked')){

            $('input:checked').parent().parent().addClass('active');

        }

       
        
 
        var wrapper         = $(".table tbody"); //Fields wrapper
        var add_button      = $(".btn-more-items"); //Add button ID
        
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x){ //max input box allowed
                x++; //text box increment

                var wrapperCreate = wrapper.hasClass('createIntovicetb');
                var wrapperEdit = wrapper.hasClass('editIntovicetb');

                if (wrapperCreate) {
                    $(wrapper).append('<tr><td><input type="text" name="itemName[]" id="tableItemName" class="itemName tableItemName" placeholder="item" required></td><td><input type="text" name="itemDescription[]" id="tableItemDescription" class="tableItemDescription" placeholder="description" required></td><td><input type="text" name="itemPrice[]" id="tableItemPrice" class="itemPrice tableItemPrice" value="0" placeholder=""></td><td><input type="text" name="itemQuantity[]" id="tableItemQuantity" class="itemQuantity itemNumeric tableItemQuantity" value="0" placeholder=""> <i class="validation"></i><input type="hidden" name="hiddenItemQty[]" class="hiddenItemQty" value=""></td><td><span id="tableItemTotal" class="totalItem itemTotal">0</span><input type="hidden" id="hiddenItemTotal" class="totalItem" name="itemTotal[]" value=""></td><td><i class="fa fa-trash btn-action remove-invoice"></i><input type="hidden" class="hiddenItemID" name="itemID[]" value=""><input type="hidden" name="itemInfinity[]" class="hiddenItemInf" value=""></td></tr>'
                    )
                } else if (wrapperEdit) {
                    $(wrapper).append('<tr><td><input type="text" name="itemName[]" id="tableItemName" class="itemName tableItemName" placeholder="item" required></td><td><input type="text" name="itemDescription[]" id="tableItemDescription" class="tableItemDescription" placeholder="description" required></td><td> <input type="text" name="itemPrice[]" id="tableItemPrice" class="itemPrice tableItemPrice" value="0" placeholder=""></td><td><input type="text" name="itemQuantity[]" id="tableItemQuantity" class="itemQuantity itemNumeric tableItemQuantity" value="0" placeholder=""> <i class="validation"></i><input type="hidden" name="hiddenItemQty[]" class="hiddenItemQty" value=""><input type="hidden" name="hiddenSavedQty[]" class="hiddenSavedQty" value="0"></td><td><span id="tableItemTotal" class="totalItem itemTotal">0</span><input type="hidden" id="hiddenItemTotal" class="totalItem" name="itemTotal[]" value=""></td><td><i class="fa fa-trash btn-action remove-invoice"></i><input type="hidden" class="hiddenItemID" name="itemID[]" value=""><input type="hidden" name="itemInfinity[]" class="hiddenItemInf" value=""></td></tr>'
                    )
                };
                

                $(".tableItemName").autocomplete(ac_config);

                disabledKey();
                decimalPlace();

                validationQuantity();
            }


            var counter = parseInt($('.itemCounter').val()) + 1;
            var ab = $('.itemCounter').val(counter);

            if (ab.val() > 0 ) {
                $('#subSave').attr('disabled', false);
            }

        });
      


        $(wrapper).on("click",".remove-invoice", function(e){ //user click on remove text
            $(this).parent().parent().remove();
            countSubTotal();
            countTax();
            countTotal();

           

            var counter = parseInt($('.itemCounter').val()) - 1;
            var ab = $('.itemCounter').val(counter);

            if($(ab).val() == 0){
                $('.subTotal').html(0);
                $('.subTotalHidden').val(0);
                parseInt($('.taxesValue').text(0));
                parseInt($('.taxesValueHidden').val(0));
                $('#sumTotal').html(0);
                $('.sumTotal').val(0);
                $('#subSave').attr('disabled', true);
            } 
            

        });

            var ab = parseInt($('.itemCounter').val());

            if(ab == 0){
                $('.subTotal').html(0);
                $('.subTotalHidden').val(0);
                parseInt($('.taxesValue').text(0));
                parseInt($('.taxesValueHidden').val(0));
                $('#sumTotal').html(0);
                $('.sumTotal').val(0);
                $('#subSave').attr('disabled', true);
            } 
        

        
        $('.btn-collpase').click(function () {
            ('.table tbody tr').removeClass('active');
        });



        /////// pop-up delete confirm //////
        $(".confirm").confirm();

        $.confirm.options = {
            text: "Are you sure?",
            title: "",
            confirmButton: "Yes, delete it!",
            cancelButton: "Cancel",
            post: false
        }


        //////////////// fade out for succsess comment //////
        $('.alert-success').fadeOut(4500);
    
  

        // Tax on change function
        $('select.taxes').change(function () {
            countTax();
            countTotal();
        });
        

        // Item's price and quantity on keyup function
        $(wrapper).on('keyup','.itemPrice, .itemQuantity',function () {
         
            var itemPrice = $(this).parent().parent().children().children('#tableItemPrice').val();
            var itemQuantity = $(this).parent().parent().children().children('#tableItemQuantity').val();
            var total = countItemTotal(itemPrice,itemQuantity);
            
            var totalItem = $(this).parent().parent().children().children('#tableItemTotal').text(total);

            countSubTotal();
            countTax();
            countTotal();

        });
    
        

        ///////// Setup - add a text input to each footer cell ///////////
        $('th.th_head').html( '<input type="text" placeholder="FILTER" style="width:100%; border-bottom:1px solid #181818;"/>' );


        $('#example').dataTable({
            "bPaginate": false,
            "bSort" : false,
            responsive: true,
            "oLanguage": {
                "sProcessing": "<img src='assets/img/ajax-loader.gif'>"
            }
        });
     
        // DataTable
        var table = $('#example').DataTable();

        /*$('#example tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('active');
        });*/

        // Apply the search
        table.columns().eq( 0 ).each( function ( colIdx ) {
            $( 'input', table.column( colIdx ).header() ).on( 'keyup change', function () {
                table
                    .column( colIdx )
                    .search( this.value )
                    .draw();
            });
        });



            
    $('#subView').on("click",function() {
        $('#invoice-form').attr('target', '_blank');
    });
    $('#subSave').on("click",function() {
        $('#invoice-form').attr('target', '_self');
    });
    $('#subMail').on("click",function() {
        $('#invoice-form').attr('target', '_self');
    });



});

    countSubTotal();
    countTax();
    countTotal();

    
</script>
    
</body>

</html>