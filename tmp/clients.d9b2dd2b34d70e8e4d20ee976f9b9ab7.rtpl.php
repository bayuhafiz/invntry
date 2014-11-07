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


        <?php if( $clients != '' ){ ?>

          <table class="table table-hover table-striped" id="example">
              <thead>
                <tr>
                  <th>FIRST NAME</th>
                  <th>LAST NAME</th>
                  <th>CITY</th>
                  <th>PHONE</th>
                  <th>EMAIL</th>
                  <th>ACTIONS</th>
                </tr>
                <tr>
                  <th class="th_head">FIRST NAME</th>
                  <th class="th_head">LAST NAME</th>
                  <th class="th_head">CITY</th>
                  <th class="th_head">PHONE</th>
                  <th class="th_head">EMAIL</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $counter1=-1; if( isset($clients) && is_array($clients) && sizeof($clients) ) foreach( $clients as $key1 => $value1 ){ $counter1++; ?>


                  <tr>
                    <td class="bold"><?php echo $value1["clientFirstname"];?></td>
                    <td class="bold"><?php echo $value1["clientLastname"];?></td>
                    <td><?php echo $value1["clientCity"];?></td>
                    <td><?php echo $value1["clientPhonenumber"];?></td>
                    <td><?php echo $value1["clientEmail"];?></td>            
                    <td>
                      <a href="clients-edit.php?id=<?php echo $value1["clientID"];?>"><i class="fa fa-pencil-square-o btn-action"></i></a>
                      <a href="?action=delete&id=<?php echo $value1["clientID"];?>" class="confirm"><i class="fa fa-trash btn-action"></i></a>
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
    <div class="col-lg-9 col-centered">
      <a href="clients-add.php"><button type="button" class="btn btn-default btn-add-client"><i class="fa fa-building-o"></i> &nbsp;Add Client</button>
    </div>
  </div>

<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>



