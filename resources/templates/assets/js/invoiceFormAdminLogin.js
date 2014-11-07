$(document).ready(function() {

$.get("login.php?check=login", function ( data ) {
  if(data=='true') {
    window.location = 'items.php';
  }
});

/* Validate and process the login form */          
$.validate({
  form : '#form-login',
  onSuccess : function () { // If validation is valid we process the form 
    
    
    var username = $("#username").val();
    var password = $("#password").val();
    var dataString = 'username=' + username + '&password=' + password;
        
    /* Make ajax call to our PHP file to save the review & rating */
    $.ajax({
        
      type : "POST",
      url : "login.php", // our php login 
      data : dataString,
      cache : false,
      beforeSend: function() {
        $('.loading').html('<img src="resources/templates/assets/img/ajax-loader.gif" />');
      },
      success : function (data) {				
        if(data=='true') {
        $(".success-msg").fadeIn(1500);
          //window.location = 'index.php';  
          setTimeout(function() {
  window.location.href = "items.php";
}, 3500);  
        } else {
          $(".loading").hide();

          $(".error-msg").fadeIn(1500);
          $(".error-msg").html(data);
          
          $("#username").focus(function () {
            $(".error-msg").hide();
          });
        }
      }
          
    });
        
    return false;

  }
});
});