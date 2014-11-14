<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>
  <div class="container">
    <div class="page-header">
      <a href="taxes.php" class="btn btn-default pull-right"><i class="glyphicon glyphicon-arrow-left"></i> Back to Tax Rates</a>
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
       <?php echo $pageContent;?>
      
      <form class="form-horizontal" role="form" method="post" action="">
      
  <div class="form-group">
    <label for="taxName" class="col-sm-2 control-label">Tax Name</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" name="taxName" id="taxName" placeholder="" value="<?php echo $taxName;?>">
    </div>
  </div>
  
  <div class="form-group">
    <label for="itemName" class="col-sm-2 control-label">Tax Rate</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" name="taxRate" id="taxRate" placeholder="" value="<?php echo $taxRate;?>">
    <p class="help-block">Example: 21%</p>
    </div>
  </div>
  

  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-8">
      <button type="submit" name="Submit" id="Submit" class="btn btn-default"><span class="glyphicon glyphicon-ok-sign"></span> Save changes</button>
    </div>
  </div>
</form>
      </div>
    </div>

  </div>
  <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>