<?php

session_start();

if(empty($_SESSION['id_user'])) {
  header("Location: login.php");
  exit();
}

require_once("db.php");

$name = $designation ="";

$sql = "SELECT * FROM users WHERE id_user='$_SESSION[id_user]'";
$result = $conn->query($sql);

if($result->num_rows > 0) { 
  while($row = $result->fetch_assoc()) {
    $name = $row['name'];
    $designation = $row['designation'];
  }
}

$_SESSION['callFrom'] = "friends.php";

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Social Network</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Header -->
  <?php include_once("header.php"); ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php include_once("sidebar.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  <section class="content-header">
      <h1>
        Friends
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-12">

        <?php
        $sql = "SELECT * FROM users WHERE id_user <> '$_SESSION[id_user]'"; // <>   != 
          $result = $conn->query($sql);

          if($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) {
                        
        ?>
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <h3 class="widget-user-username"><?php echo $row['name']; ?></h3>
              <h5 class="widget-user-desc"><?php echo $row['designation']; ?></h5>
            </div>
            <?php if($row['profileimage'] != "") { ?>
            <div class="widget-user-image">
              <img class="img-circle" src="uploads/profile/<?php echo $row['profileimage']; ?>" alt="User Avatar">
            </div>
            <?php } else { ?>
            <div class="widget-user-image">
              <img class="img-circle" src="dist/img/avatar5.png" alt="User Avatar">
            </div>
            <?php } ?>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <?php
                $sql1 = "SELECT * FROM friends WHERE id_user='$_SESSION[id_user]' AND id_frienduser='$row[id_user]'";
                  $result1 = $conn->query($sql1);

                  if($result1->num_rows > 0) { 
                                
                ?>
                  <div class="description-block">
                    <a href="messages.php?id=<?php echo $row['id_user']; ?>" class="btn bg-purple bg-flat">Send Message</a>
                  </div>
                  <?php  } ?>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <a href="view-profile.php?id=<?php echo $row['id_user']; ?>" class="btn bg-maroon bg-flat">View Profile</a>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                <?php
                $sql1 = "SELECT * FROM friends WHERE id_user='$_SESSION[id_user]' AND id_frienduser='$row[id_user]'";
                  $result1 = $conn->query($sql1);

                  if($result1->num_rows > 0) { 
                                
                ?>
                  <div class="description-block">
                    <a href="remove-friend.php?id=<?php echo $row['id_user']; ?>" class="btn bg-orange bg-flat">Remove Friend</a>
                  </div>
                <?php 
                  } else {
                    $sql2 = "SELECT * FROM friendrequest WHERE id_user='$row[id_user]' AND id_friend='$_SESSION[id_user]'";
                    $result2 = $conn->query($sql2);

                    if($result2->num_rows == 0) { 

                    $sql3 = "SELECT * FROM friendrequest WHERE id_user = '$_SESSION[id_user]' AND id_friend='$row[id_user]'"; 
                      $result3 = $conn->query($sql3);
                      if($result3->num_rows == 0) { 
                    ?>
                    <div class="description-block">
                      <a href="send-request.php?id=<?php echo $row['id_user']; ?>" class="btn bg-green bg-flat">Add Friend</a>
                    </div>
                  <?php } else { ?>
                  <div class="description-block">
                      <a href="accept-request.php?id=<?php echo $row['id_user']; ?>" class="btn bg-maroon bg-flat">Accept Friend</a>
                  </div>
                  <?php } ?>
                    <?php } else {?>
                    <div class="description-block">
                      <button class="btn bg-purple bg-flat" disabled>Request Sent</button>
                    </div>
                    
                  <?php } } ?>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
        <?php
            }
          }
        ?>
          
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2016-2017 <a href="#">Social Network</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
