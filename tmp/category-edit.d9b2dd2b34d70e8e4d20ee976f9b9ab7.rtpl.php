<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>
  <div class="container">
    <div class="page-header">
      <a href="categories.php" class="btn btn-default pull-right"><i class="glyphicon glyphicon-arrow-left"></i> Back to Categories</a>
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
    <label for="catName" class="col-sm-2 control-label">Name</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" name="catName" id="catName" placeholder="" value="<?php echo $catName;?>">
    </div>
  </div>
  
  <div class="form-group">
    <label for="catDescription" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-8">
    <textarea name="catDescription" id="catDescription" class="form-control"><?php echo $catDescription;?></textarea>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-8">
      <button type="submit" name="Submit" id="Submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Save changes</button>
    </div>
  </div>
</form>
      </div>
    </div>

  </div>
  <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>