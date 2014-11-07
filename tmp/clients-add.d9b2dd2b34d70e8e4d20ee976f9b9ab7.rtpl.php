<?php if(!class_exists('raintpl')){exit;}?> <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>
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


<div class="bg-modal-client">
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
            <a href="clients.php" class="close-modal">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>  

    <div class="container">
        <div class="row">
            <div class="col-lg-8 centered-div">
                <form role="form" method="post" action="">
                    <div class="row row-centered">
                        <div class="col-lg-12">
                            <h1 class="modal-title"><i class="fa fa-plus"></i> ADD CLIENT</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group width-input">
                                        <input type="text" class="form-control" name="clientFirstname" id="clientFirstname" placeholder="FIRST NAME" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group width-input">
                                        <input type="text" class="form-control" name="clientLastname" id="clientLastname" placeholder="LAST NAME" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group width-input">
                                        <input type="text" class="form-control" name="clientCompany" id="clientCompany" placeholder="COMPANY NAME" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group width-input">
                                        <input type="email" class="form-control" name="clientEmailaddress" id="clientEmailaddress" placeholder="EMAIL ADDRESS" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group width-input">
                                        <input type="text" class="form-control" name="clientAddress1" id="clientAddress1" placeholder="ADDRESS LINE 1" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group width-input">
                                        <input type="text" class="form-control" name="clientAddress2" id="clientAddress2" placeholder="ADDRESS LINE 2">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="input-group width-input">
                                        <input type="text" class="form-control" name="clientZipcode" id="clientZipcode" placeholder="POSTAL CODE" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-group width-input">
                                        <input type="text" class="form-control" name="clientCity" id="clientCity" placeholder="CITY" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-group width-input">
                                        <input type="text" class="form-control" name="clientCountry" id="clientCountry" placeholder="COUNTRY" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group width-input">
                                        <input type="text" class="form-control" name="clientPhonenumber" id="clientPhonenumber" placeholder="PHONE #" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6" style="float:right;width: 43.2%;">
                                    <button type="submit" name="Save" alt="Save" class="btn btn-default btn-add-client" style="border-radius:0;"><i class="fa fa-floppy-o"></i> &nbsp;Save</button>
                                    <button type="submit" name="SaveAdd" alt="SaveAdd" class="btn btn-default btn-add-client" style="border-radius:0;"><i class="fa fa-floppy-o"></i> &nbsp;Save & add more client</button>
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
  