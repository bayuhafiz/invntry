<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>
  <div class="container">
    <div class="page-header">
      <h2><?php echo $pageTitle;?></h2>
    </div>

    <div class="row rating-example">
      <div class="col-md-12 ">
       <?php if( $successMsg != '' ){ ?>
        <div class="alert alert-success alert-dismissable">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       <?php echo $successMsg;?>
       </div>
       <?php } ?>
      <?php if( $errorMsg != '' ){ ?><div class="alert alert-danger alert-dismissable">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       <?php echo $errorMsg;?>
       </div>
       <?php } ?>
      <?php if( $infoMsg != '' ){ ?><div class="alert alert-info alert-dismissable">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       <?php echo $infoMsg;?>
       </div>
       <?php } ?>

      <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
      <h3>Invoices markup</h3><br>
  <div class="form-group">
    <label for="setCurrency" class="col-sm-2 control-label">Currency</label>
    <div class="col-sm-8">
    <select class="form-control" id="setCurrency" name="setCurrency">
    <option value="euro" <?php if( $setCurrency == 'euro' ){ ?> selected="selected"<?php } ?>>&euro; EURO</option>
    <option value="usd" <?php if( $setCurrency == 'usd' ){ ?> selected="selected"<?php } ?>>&dollar; USD</option>
    </select>
    <p class="help-block">Select the currency you would like to display on your PDF invoices.</p>
    </div>
  </div>
  
  <div class="form-group">
    <label for="setLogo" class="col-sm-2 control-label">Default logo</label>
    <div class="col-sm-8">
    <img src="resources/templates/../../<?php echo $setLogo;?>" alt="My invoice logo" width="50%" style="margin:10px 0 20px 0;">
    <input type="file" class="form-control" name="setLogo" id="setLogo" placeholder="">
    <p class="help-block">Upload your default logo you want to display on your invoices. only JPG, GIF or PNG allowed.</p>
    </div>
  </div>
  
  <div class="form-group">
    <label for="setInvoiceAddress" class="col-sm-2 control-label">Invoice address</label>
    <div class="col-sm-8">
    <textarea name="setInvoiceAddress" id="setInvoiceAddress" class="form-control" rows="10"><?php echo $setInvoiceAddress;?></textarea>
    </div>
  </div>

  <div class="form-group">
    <label for="setInvoiceAddress" class="col-sm-2 control-label">Bank account</label>
    <div class="col-sm-8">
    <textarea name="setBankAccount" id="setBankAccount" class="form-control" rows="10"><?php echo $setBankAccount;?></textarea>
    </div>
  </div>

  <hr>
<h3>Send invoices by email</h3>
<br>
  <div class="form-group">
    <label for="setDefaultName" class="col-sm-2 control-label">Default name</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" name="setDefaultName" id="setDefaultName" placeholder="John Doe" value="<?php echo $setDefaultName;?>">
     <p class="help-block">Under what name would you like to send invoices by email? eg: Your Company Ltd.</p>
    </div>
  </div>

  <div class="form-group">
    <label for="setDefaultSubject" class="col-sm-2 control-label">Default subject</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" name="setDefaultSubject" id="setDefaultSubject" placeholder="John Doe" value="<?php echo $setDefaultSubject;?>">
     <p class="help-block">Under what subject would you like to send invoice by email? You can use {invoiceNr} and {invoiceAmount} tags to spice it up.</p>
    </div>
  </div>

  <div class="form-group">
    <label for="setDefaultMsg" class="col-sm-2 control-label">Default message</label>
    <div class="col-sm-8">
    <textarea class="form-control setDefaultMsg" name="setDefaultMsg" id="setDefaultMsg" rows="15"><?php echo $setDefaultMsg;?></textarea>
     <p class="help-block">Default message to display when sending invoices by email. You can use {invoiceNr} and {invoiceAmount} tags to spice it up.</p>
    </div>
  </div>
  
  <div class="form-group">
    <label for="setDefaultEmail" class="col-sm-2 control-label">Default email</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" name="setDefaultEmail" id="setDefaultEmail" placeholder="name@domain.com" value="<?php echo $setDefaultEmail;?>">
     <p class="help-block">This will be used the send From and Reply to emailaddress while mailing invoices.</p>
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-8" style="margin-bottom:150px; margin-top:30px;">
      <button type="submit" name="Submit" id="Submit" class="btn btn-default pull-right"><span class="glyphicon glyphicon-ok-sign"></span> Save changes</button>
    </div>
  </div>
</form>

       </div>
    </div>

  </div>
  <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>