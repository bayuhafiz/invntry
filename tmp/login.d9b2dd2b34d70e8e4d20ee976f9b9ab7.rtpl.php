<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE HTML>

<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    
    <title>INVNTRY &trade;</title>
    
    <meta name="viewport" content="width=device-width">
    <!-- Bootstrap stylesheet -->
    <link rel="stylesheet" type="text/css" href="resources/templates/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="resources/templates/assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="resources/templates/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/responsive/1.0.1/css/dataTables.responsive.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script type="text/javascript" src="resources/templates/assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/responsive/1.0.1/js/dataTables.responsive.js"></script>

</head>

<body>

<div class="container" style="text-align: -webkit-center; margin-top:40px;">

  <div class="login col-sm-4 col-centered">

    <form class="form-login" role="form" method="POST" id="form-login" action="login.php">
      <h3><center><img src="resources/templates/img/logo.png" /> &trade;</center></h3><br/>
      
      <div class="error-msg alert alert-danger" id="error-msg" style="display:none;">You have entered a invalid login.</div>
      <div class="success-msg alert alert-success" id="success-msg" style="display:none;">You have logged in. Please wait... <div class="loading"></div></div>
      
      <div class="form-group">
        <div>
          <input type="text" class="form-control" id="username" name="username" placeholder="Your username" data-validation="required"  data-validation-error-msg="Please enter your username." autocomplete="off" required>
        </div>
      </div>

      <div class="form-group">
        <div>
          <input type="password" class="form-control" id="password" name="password" placeholder="*********" data-validation="required"  data-validation-error-msg="Please enter your password." autocomplete="off" required>
        </div>
      </div>

      <div class="form-group">
        <div>
          <button type="submit" class="btn btn-default">Login</button>
        </div>
      </div>
    </form>
</div>
  
  <div class="login-footer"><br/>
    <p>Copyright &copy; 2014 by <strong>Colorblind Labs</strong>. All rights reserved.</p>
  </div>
  
</div>

</body>

</html>