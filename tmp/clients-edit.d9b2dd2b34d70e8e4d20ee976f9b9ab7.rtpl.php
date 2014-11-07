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

  <div class="bg-modal-editClient">

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

      <form class="form-horizontal" role="form" method="post" action="">
        <div class="row">
            <div class="col-lg-12">
                <a href="clients.php" class="close-modal">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>  
        <div class="row row-centered">
            <div class="col-lg-12">
            <h1 class="modal-title"><i class="fa fa-pencil-square-o"></i> Edit CLIENT</h1>
            </div>
        </div>
        <div class="row row-centered">
            <div class="col-lg-5 col-centered">
              <div class="row">
                <div class="col-lg-6">
                  <div class="input-group width-input">
                    <input type="text" name="clientFirstname" id="clientFirstname" class="form-control" value="<?php echo $clientFirstname;?>">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="input-group width-input">
                    <input type="text" name="clientLastname" id="clientLastname" class="form-control" value="<?php echo $clientLastname;?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="input-group width-input">
                    <input type="text" name="clientCompany" id="clientCompany" class="form-control" value="<?php echo $clientCompany;?>">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="input-group width-input">
                    <input type="text" class="form-control" name="clientEmailaddress" id="clientEmailaddress" value="<?php echo $clientEmailaddress;?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="input-group width-input">
                  <input type="text" class="form-control" name="clientAddress1" id="clientAddress1" value="<?php echo $clientAddress1;?>">
                </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="input-group width-input">
                  <input type="text" class="form-control" name="clientAddress2" id="clientAddress2" value="<?php echo $clientAddress2;?>">
                </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-4">
                  <div class="input-group width-input">
                  <input type="text" class="form-control" name="clientZipcode" id="clientZipcode" value="<?php echo $clientZipcode;?>">
                </div>
                </div>
                <div class="col-lg-4">
                  <div class="input-group width-input">
                  <input type="text" class="form-control" name="clientCity" id="clientCity" value="<?php echo $clientCity;?>">
                </div>
                </div>
                <div class="col-lg-4">
                  <div class="input-group width-input">
                  <input type="text" class="form-control" name="clientCountry" id="clientCountry" value="<?php echo $clientCountry;?>">
                </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="input-group width-input">
                  <input type="text" class="form-control" name="clientPhonenumber" id="clientPhonenumber" value="<?php echo $clientPhonenumber;?>">
                </div>
                </div>
              </div>
            </div>
        </div>
        <div class="row row-centered" >
            <div class="col-lg-12">
                <button type="submit" name="Submit" id="Submit" class="btn btn-default btn-save-product" style="margin-left: 462px;border-radius:0;"><i class="fa fa-floppy-o"></i> &nbsp;Save</button>
                
            </div>
        </div>
      </form>
  </div>
<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>