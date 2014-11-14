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

<div class="bg-modal-addCategory">
      
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
      <a href="categories.php" class="close-modal">
        <i class="fa fa-times"></i>
      </a>
    </div>
  </div> 
  
  <div class="container">
    <div class="row">
      <div class="col-lg-10 centered-div"> 

        <form role="form" method="post" action="">

          <div class="row row-centered">
            <div class="col-lg-12">
              <h1 class="modal-title"><i class="fa fa-plus"></i> ADD CATEGORY</h1>
            </div>
          </div>

          <div class="row">

            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-6 centered-div">
                  <div class="input-group width-input">
                    <input type="text" class="form-control" name="catName" id="catName" placeholder="CATEGORY NAME" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 centered-div">
                  <div class="input-group width-input">
                    <input type="text" class="form-control" name="catDescription" id="catDescription" placeholder="DESCRIPTION" required>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12" style="margin-top:50px;">
              <div class="row">
                <div class="col-lg-6 centered-div" style="width: 43.2%;">
                  <button type="submit" name="Save" alt="Save" class="btn btn-default" style="border-radius:0;">
                    <i class="fa fa-floppy-o"></i> Save category
                  </button>
                  <button type="submit" name="SaveAdd" alt="SaveAdd" class="btn btn-default" style="border-radius:0;">
                    <i class="fa fa-floppy-o"></i> Save & add more category
                  </button>
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