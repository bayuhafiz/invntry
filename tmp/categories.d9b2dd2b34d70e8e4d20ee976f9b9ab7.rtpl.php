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

        <?php if( $errorMsg != '' ){ ?>
          <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $errorMsg;?>
          </div>
        <?php } ?>
        <?php if( $categories != '' ){ ?>
        
        <table class="table table-hover table-striped" id="example">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th data-hide="phone">DESCRIPTION</th>
                    <th data-hide="phone">ACTIONS</th>
                </tr>
                <tr>
                  <th class="th_head">FIRST NAME</th>
                  <th class="th_head">LAST NAME</th>
                  <th></th>
                </tr>
            </thead>
            <tbody>
              <?php $counter1=-1; if( isset($categories) && is_array($categories) && sizeof($categories) ) foreach( $categories as $key1 => $value1 ){ $counter1++; ?>
                  <tr>
                      <td class="bold"><?php echo $value1["catName"];?></td>
                      <td><?php echo $value1["catDescription"];?></td>
                      <td>
                          <a href="category-edit.php?id=<?php echo $value1["catID"];?>"><i class="fa fa-pencil-square-o btn-action" data-toggle="tooltip2" data-placement="left" title="Click to edit product"></i></a>
                          <a href="?action=delete&id=<?php echo $value1["catID"];?>" class="confirm"><i class="fa fa-trash"></i></a>
                      </td>
                  </tr>
              <?php } ?>
            </tbody>
        </table>

      </div>
        <?php } ?>
    </div>
    <div class="row row-centered" style="margin-top:40px;margin-bottom:150px;">
      <div class="col-lg-9 col-centered">
          <a href="category-add.php"><button type="button" class="btn btn-default"><i class="fa fa-building-o"></i> &nbsp;Add Category
          </button></a>
      </div>
    </div>  

  </div>
  <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>