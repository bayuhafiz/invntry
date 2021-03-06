<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>

    <style type="text/css">
        .delete-logo {
            display: none;
            margin-top: 10px;
            border: 2px solid #178cd9 !important;
            color: #178cd9 !important;
            border-radius: 0;
        }

        .navbar-default, .footer{
            display: none;
        }
    </style>

    <script type="text/javascript">
            function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img_prev')
                    .attr('src', e.target.result)
                    .width(208);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }  
    </script>
    
    <div class="bg-modal-editProduct">
      <?php if( $successMsg != '' ){ ?>

        <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?php echo $successMsg;?>

        </div>
      <?php } ?>

      <?php if( $errorMsg != '' ){ ?>

        <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?php echo $errorMsg;?>

        </div>
      <?php } ?>

      <?php if( $infoMsg != '' ){ ?>

        <div class="alert alert-info alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?php echo $infoMsg;?>

        </div>
      <?php } ?>


    <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12">
                <a href="items.php" class="close-modal">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>  
        <div class="row row-centered">
            <div class="col-lg-12">
                <h1 class="modal-title"><i class="fa fa-pencil-square-o"></i> EDIT PRODUCT</h1>
            </div>
        </div>
        <div class="row row-centered">
            <div class="col-lg-2 col-centered">
                <div class="input-group">
                        <div class="btn-group col-sm-8">          
                            <div id="logo" style="width: 208px;height: 200px;" >
                                <div class="logo_prev">
                                    <?php if( $itemImage=='' ){ ?>

                                        <img id="img_prev" src="resources/templates/img/no_image.png" alt="Product Image" class="img-thumbnail img-responsive"/ style="width: 208px; height:auto; ">
                                    <?php }else{ ?>

                                        <img id="img_prev" src="resources/templates/../../<?php echo $itemImage;?>" alt="Product Image" class="img-thumbnail img-responsive"/ style="width: 208px; height:auto; ">
                                    <?php } ?>

                                </div>
                                <br>
                                <input type='file' onchange="readURL(this);" name="itemImage" class="select-logo" />
                                <a class="delete-logo btn btn-default" id="delete-logo" href="javascript:;" title="Remove row"><span class="glyphicon glyphicon-remove-circle"></span> Delete image</a>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-lg-4 col-centered" style="top:-27px;left: 18px;">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group width-input">
                            <input type="text" class="form-control" name="itemName" id="itemName" placeholder="NAME" value="<?php echo $itemName;?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group width-input">
                            <select class="form-control" name="itemCategory" id="itemCategory" style="width: 100%;height: 34px;">
                              <?php $counter1=-1; if( isset($dataCat) && is_array($dataCat) && sizeof($dataCat) ) foreach( $dataCat as $key1 => $value1 ){ $counter1++; ?>

                                <?php if( $value1["catID"] == $selectedCatID ){ ?>

                                    <option value="<?php echo $value1["catID"];?>" selected><?php echo $value1["catName"];?></option>
                                <?php }else{ ?>

                                    <option value="<?php echo $value1["catID"];?>"><?php echo $value1["catName"];?></option>
                                <?php } ?>

                              <?php } ?>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group width-input">
                            <input type="text" class="form-control" name="itemDescription" id="itemDescription" placeholder="DESCRIPTION" value="<?php echo $itemDescription;?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group width-input">
                        <?php if( $itemInfinity=='1' ){ ?>

                            <input type="text" class="form-control" id="itemQuantity" name="itemQuantity" placeholder="QUANTITY" value="1" disabled>
                        <?php }else{ ?>

                            <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="itemQuantity" name="itemQuantity" placeholder="QUANTITY" value="<?php echo $itemQuantity;?>">
                        <?php } ?>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group width-input">
                            <input type="text" class="form-control itemPrice" name="itemPrice" id="itemPrice" placeholder="PRICE" value="<?php echo $itemPrice;?>">
                        </div>
                        <span id="itemPriceMsg" class="message"></span>
                    </div>
                </div>
                <div class="row">
                        <div class="col-lg-6">Infinite item?&nbsp;&nbsp;
                            <div class="btn-group" data-toggle="buttons">  
                                <?php if( $itemInfinity=='0' ){ ?>

                                    <label class="btn btn-primary active" id="no-infinity">
                                        <input name="infinity" value="0" checked="checked" type="radio">No
                                    </label>
                                    <label class="btn btn-primary" id="yes-infinity">
                                        <input name="infinity" id="yes-input" value="1" type="radio">Yes
                                    </label>
                                <?php }else{ ?>

                                    <label class="btn btn-primary" id="no-infinity">
                                        <input name="infinity" value="0" type="radio">No
                                    </label>
                                    <label class="btn btn-primary active" id="yes-infinity">
                                        <input name="infinity" id="yes-input"  checked="checked" value="1" type="radio">Yes
                                    </label> 
                                <?php } ?>

                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="row row-centered" style="margin-top:100px;" >
            <div class="col-lg-12">
                <button type="submit" name="Submit" id="Submit" class="btn btn-default btn-save-product saveItemEdit" style="margin-left: 615px;border-radius:0;"><i class="fa fa-floppy-o"></i> &nbsp;Save</button>
                
            </div>
        </div>
    </form>
    </div>

<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>



  