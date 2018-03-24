<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Socail Network | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!-- Custom -->
  <link rel="stylesheet" href="dist/css/custom.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index2.html"><b>Social </b>Network</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Create an account</p>

    <form id="registerForm" action="index.html" method="post">
      <div class="form-group has-feedback">
        <input type="text" id="name" name="name" class="form-control" placeholder="Full name" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <span id="nameError" class="color-red hide-me">Name Error</span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <span id="emailError" class="color-red hide-me">Email Error</span>
        <span id="emailExistsError" class="color-red hide-me">Email Error</span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span id="passwordError" class="color-red hide-me">Password Error</span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" id="cpassword" name="cpassword" class="form-control" placeholder="Retype password" required>
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        <span id="cpasswordError" class="color-red hide-me">Confirm Password Error</span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" required> I agree to the <a href="#">terms</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button id="sbtBtn" type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="login.php" class="text-center">I already have an account</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<!-- Custom -->
<script>
  $('#registerForm').on("submit", function(e) {
    e.preventDefault();

    var errors = false;

    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    //Minimum 8 Characters with at least 1 letter and 1 number
    var passwordReg = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

    if($("#name").val().length < 5) {
      $("#nameError").text("Name Should Be Of Atleast 5 Chars");
      $("#nameError").show();
      errors = true;
    } else {
      $("#nameError").hide();
    }
 

    if(passwordReg.test($("#password").val())) {
      $("#passwordError").hide();
    } else {
        $("#passwordError").text("Password must be of 8 characters with at least 1 letter and 1 number");
        $("#passwordError").show();
        errors = true;
    }

    if($("#cpassword").val() === $("#password").val()) {
      $("#cpasswordError").hide();
    } else {
        $("#cpasswordError").text("Password Mismatch");
        $("#cpasswordError").show();
        errors = true;
    }

    if(errors == false) {
      if(emailReg.test($("#email").val())) {
        $("#emailError").hide();
        $.post("checkemail.php", { email: $("#email").val()}).done(function(data) {
          var result = $.trim(data);
          if(result == "Error") {
            $("#emailExistsError").text("This email is already registered with us. Choose Different Email.");
            $("#emailExistsError").show();
          } else {
            $("#emailExistsError").hide();
            adduser();
          } 
        });
      } else {
          $("#emailError").text("Email should be of format example@example.com");
          $("#emailError").show();
      }
    }
    



  });
</script>
<script>
  function adduser() {
     $.post("adduser.php", $("#registerForm").serialize() ).done(function(data) {
        var result = $.trim(data);
        if(result == "ok") {
          window.location.href = "login.php";
        }
      });
  }
</script>
</body>
</html>
