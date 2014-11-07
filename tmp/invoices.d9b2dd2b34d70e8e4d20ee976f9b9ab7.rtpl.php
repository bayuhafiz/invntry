<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>

  <div class="row row-centered">
    <div class="col-lg-8 col-centered">
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

      
        <?php if( $invoices != '' ){ ?>

        <table class="table table-hover table-striped" id="example">
          <thead>
            <tr>
              <th>CLIENT NAME</th>
              <th>VALUE (TOTAL)</th>
              <th>CREATE DATE</th>
              <th>DUE DATE</th>
              <th>ACTIONS</th>
            </tr>
            <tr>
              <th class="th_head">ID</th>
              <th class="th_head">NAME</th>
              <th class="th_head">DESCRIPTION</th>
              <th class="th_head">CATEGORY</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php $counter1=-1; if( isset($invoices) && is_array($invoices) && sizeof($invoices) ) foreach( $invoices as $key1 => $value1 ){ $counter1++; ?>

              <tr>
                <td class="bold"><?php echo $value1["invoiceClient"];?></td>
                <td><?php echo $value1["currency"];?> <?php echo $value1["invoiceAmount"];?></td>
                <td><?php echo $value1["invoiceDate"];?></td>
                <td><?php echo $value1["invoiceDuedate"];?></td>
                <td>
                  <a href="edit-invoice.php?id=<?php echo $value1["invoiceID"];?>"><i class="fa fa-pencil-square-o btn-action" data-toggle="tooltip" data-placement="left" title="View & edit invoice"></i></a>
                  <i class="fa fa-download btn-action" data-toggle="tooltip" data-placement="left" title="Download PDF"></i>
                  <i class="fa fa-envelope btn-action" data-toggle="tooltip" data-placement="left" title="Send to email"></i>
                  <a href="?action=delete&id=<?php echo $value1["invoiceID"];?>" class="confirm"><i class="fa fa-trash btn-action" ></i></a>
                </td>
              </tr>
            <?php } ?>

          </tbody>
        </table>
        <?php } ?>

      </div>
    </div>
  </div>
  <div class="row row-centered" style="margin-top:40px;margin-bottom:150px;">
    <div class="col-lg-8 col-centered">
      <a href="create-invoice.php"><button type="button" class="btn btn-default btn-add-product"><i class="fa fa-building-o"></i> &nbsp;Create Invoice</button></a>
    </div>
  </div>


<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>