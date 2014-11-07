<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>


  <div class="row row-centered">
    <form action="create-invoice.php" method="POST">
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


          <?php if( $items != '' ){ ?>

            <table class="table table-hover table-striped" id="example">
              <thead>
                <tr>
                  <th></th>
                  <th>NAME</th>
                  <th>DESCRIPTION</th>
                  <th>CATEGORY</th>
                  <th>QTY</th>
                  <th>PRICE</th>
                  <th>ACTIONS</th>
                </tr>
                <tr>
                  <th></th>
                  <th class="th_head">NAME</th>
                  <th class="th_head">DESCRIPTION</th>
                  <th class="th_head">CATEGORY</th>
                  <th class="th_head">QTY</th>
                  <th class="th_head">PRICE</th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="tbodyItems">
                <?php $counter1=-1; if( isset($items) && is_array($items) && sizeof($items) ) foreach( $items as $key1 => $value1 ){ $counter1++; ?>

                      
                <tr>
                  <td class="borderLeft"><input type="checkbox" class="foo" name="check_list[]" value="<?php echo $value1["itemID"];?>"></td>
                  <td class="bold"><?php echo $value1["itemName"];?></td>
                  <td><?php echo $value1["itemDescription"];?></td>
                  <td><?php echo $value1["itemCategory"];?></td>
                  <td><?php echo $value1["itemQuantity"];?></td>
                  <td><?php echo $currency;?> <?php echo $value1["itemPrice"];?></td>
                  <td>
                    <?php if( $value1["itemImage"] != '' ){ ?>

                      <a href="<?php echo $value1["itemImage"];?>" data-lightbox="<?php echo $value1["itemImage"];?>"><i class="fa fa-search btn-action-search" data-toggle="tooltip1" data-placement="left" title="Click to view image" style="padding-right: 10px;"></i></a>
                    <?php }else{ ?>

                       <i class="fa fa-search btn-action-search" data-toggle="tooltip1" data-placement="left" title="Click to view image" style="padding-right: 10px;"></i>
                    <?php } ?>

                      <a href="items-edit.php?id=<?php echo $value1["itemID"];?>"><i class="fa fa-pencil-square-o btn-action" data-toggle="tooltip2" data-placement="left" title="Click to edit product"></i></a>
                      <a href="?action=delete&id=<?php echo $value1["itemID"];?>" class="confirm">
                        <i class="fa fa-trash btn-action"></i>
                      </a>
                      <!-- <i class="fa fa-plus btn-action btn-collpase" data-toggle="collapse" data-target="#accordion" ></i> -->
                  </td>
                </tr>
                <?php } ?>

              </tbody>
            </table>
          <?php } ?>



      </div>
    </div>
  </div>

  <div class="row row-centered" style="margin-top:50px;margin-bottom:150px;">
    <!-- <div class="col-lg-6">
        <button type="button" class="btn btn-default btn-add-product" style="right: 100px;border-radius:0;"><i class="fa fa-building-o"></i> &nbsp;Add Product
        </button>
    </div> -->
    <div class="col-lg-4 col-centered">
        <a href="items-add.php"><button type="button" class="btn btn-default btn-add-product pull-left" ><i class="fa fa-building-o"></i> &nbsp;Add Product</button></a>
    </div>
    <div class="col-lg-4 col-centered">
      <button type="submit" class="btn btn-default btn-create-order pull-right" disabled="disabled"><i class="fa fa-shopping-cart"></i> &nbsp;Create Order</button>
    </div>
    <div id="count"></div>
  </form>
  </div>


<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>



