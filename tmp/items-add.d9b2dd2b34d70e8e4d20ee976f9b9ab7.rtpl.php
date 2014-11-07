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

    
    <script>
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

    </script>

        
    <div class="bg-modal-product">
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



        <div class="row">
            <div class="col-lg-12">
                <a href="items.php" class="close-modal">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div> 

        <div class="container">
            <div class="row">
                <div class="col-lg-10 centered-div">
                    <form role="form" method="post" action="items-add.php"  enctype="multipart/form-data">
                        <div class="row row-centered">
                            <div class="col-lg-12">
                                <h1 class="modal-title"><i class="fa fa-plus"></i> ADD PRODUCT</h1>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <div class="btn-group col-sm-8">          
                                                <div id="logo" style="width: 208px;height: auto;" >
                                                    <div class="logo_prev" id="drop-area">
                                                        <img id="img_prev" src="resources/templates/img/picture_icon.png" alt="Product Image" class="img-thumbnail img-responsive"/ style="width: 208px; height:auto; ">
                                                    </div>
                                                    <br>
                                                    <input id="itemImage" name="itemImage" type='file' onchange="readURL(this);" required/>
                                                    <a class="delete-logo btn btn-default" id="delete-logo" href="javascript:;" title="Remove row"><span class="glyphicon glyphicon-remove-circle"></span> Delete image</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-group width-input">
                                                    <input type="text" class="form-control" name="itemName" id="itemName" placeholder="NAME" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="input-group width-input">
                                                    <select class="form-control" name="itemCategory" id="itemCategory" style="width: 100%;height: 34px;">
                                                        <option selected="selected">SELECT CATEGORY</option>
                                                      <?php $counter1=-1; if( isset($dataCat) && is_array($dataCat) && sizeof($dataCat) ) foreach( $dataCat as $key1 => $value1 ){ $counter1++; ?>

                                                        <option value="<?php echo $value1["catID"];?>"><?php echo $value1["catName"];?></option>
                                                      <?php } ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-group width-input">
                                                    <input type="text" class="form-control" name="itemDescription" id="itemDescription" placeholder="DESCRIPTION" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-group width-input">
                                                    <input type="text" onkeypress="return isNumberKey(event)" class="form-control itemNumeric" name="itemQuantity" id="itemQuantity" placeholder="QUANTITY" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="input-group width-input">
                                                    <input type="text" class="form-control itemPrice" name="itemPrice" id="itemPrice"  placeholder="PRICE" required/>
                                                </div>
                                                <span id="itemPriceMsg" class="message"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">Infinite item?&nbsp;&nbsp;
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-primary active" id="no-infinity">
                                                        <input name="infinity" value="0" checked="checked" type="radio">No
                                                    </label>
                                                    <label class="btn btn-primary" id="yes-infinity">
                                                        <input name="infinity" value="1" type="radio">Yes
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6" style="float:right;width: 33.4%;">
                                        <button type="submit" name="Save" id="Save" class="btn btn-default saveItemAdd" style="border-radius:0;"><i class="fa fa-floppy-o"></i> &nbsp;Save</button>
                                        <button type="submit" name="SaveAdd" id="SaveAdd" class="btn btn-default saveItemAddMore" style="border-radius:0;"><i class="fa fa-plus"></i> &nbsp;Save and Add More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>

        

