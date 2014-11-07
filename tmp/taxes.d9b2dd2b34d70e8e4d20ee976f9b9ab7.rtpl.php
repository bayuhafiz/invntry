<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>


  <div class="row row-centered">
    <div class="col-lg-9 col-centered">
      <div class="table-responsive">

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

  
      
      <?php if( $taxes != '' ){ ?>

        <table class="table table-hover table-striped" id="example">
            <thead>
                <tr> 
                    <th>Name</th>
                    <th>Rate</th>
                    <th>Actions</th>
                </tr>
                <tr>
                  <th class="th_head">FIRST NAME</th>
                  <th class="th_head">LAST NAME</th>
                  <th></th>
                </tr>
            </thead>
            <tbody>
            <?php $counter1=-1; if( isset($taxes) && is_array($taxes) && sizeof($taxes) ) foreach( $taxes as $key1 => $value1 ){ $counter1++; ?>

                <tr>
                    <td><?php echo $value1["taxName"];?></td>
                    <td><?php echo $value1["taxRate"];?></td>
                    <td>
                        <a href="taxes-edit.php?id=<?php echo $value1["taxID"];?>"><i class="fa fa-pencil-square-o"></i></a>
                        <a href="#" class="confirm" data-taxid="<?php echo $value1["taxID"];?>" data-taxname="<?php echo $value1["taxName"];?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
        <?php } ?>

      </div>
    </div>
  </div>

  <div class="row row-centered">
    <div class="col-lg-9 col-centered" style="margin-top:65px;">
      <a href="taxes-add.php"><button class="btn btn-default"><i class="fa fa-money"></i> Add taxrate</button></a>
    </div>
  </div>

<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>