<?php

session_start();

if(empty($_SESSION['id_user'])) {
  header("Location: login.php");
  exit();
}

if(empty($_GET['id'])) {
  header("Location: pages.php");
  exit();
}


require_once("db.php");

$name = $description = "";

$sql = "SELECT * FROM pages WHERE id_page='$_GET[id]'";
$result = $conn->query($sql);

if($result->num_rows > 0) { 
  while($row = $result->fetch_assoc()) {
    $name = $row['name'];
    $description = $row['description'];
    $logo = $row['logo'];
  }
}

$_SESSION['callFrom'] = "view-page.php?id=".$_GET['id'];

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
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css"> -->
  <!-- jvectormap -->
  <!-- <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="dist/css/custom.css">

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


    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
            <?php
                    echo '<img src="uploads/pages/'.$logo.'" class="profile-user-img img-responsive img-circle" alt="User Image">';
                
                ?>

              <h3 class="profile-username text-center"><?php echo $name; ?></h3>

              <p class="text-muted text-center"><?php echo $description; ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <?php
                   $sql1 = "SELECT * FROM page_followers WHERE id_page='$_GET[id]'";
                    $result1 = $conn->query($sql1);
                    if($result1->num_rows > 0) {
                      $totalno = $result1->num_rows;
                    } else {
                      $totalno = 0;
                    }
                  ?>
                  <b>Followers</b> <a class="pull-right"><?php echo $totalno; ?></a>
                </li>
              </ul>

              <?php
                $sql1 = "SELECT * FROM page_followers WHERE id_user='$_SESSION[id_user]' AND id_page='$_GET[id]'";
                $result1 = $conn->query($sql1);
                if($result1->num_rows == 0) {
              ?>
                  <a href="page-follow.php?id=<?php echo $_GET['id']; ?>" class="btn btn-primary btn-block"><b>Follow</b></a>
              <?php } else { ?>
                  <a href="page-unfollow.php?id=<?php echo $_GET['id']; ?>" class="btn btn-danger btn-block"><b>UnFollow</b></a>
              <?php } ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <?php
                $sql1 = "SELECT * FROM pages WHERE id_user='$_SESSION[id_user]'";
                  $result1 = $conn->query($sql1);

                  if($result1->num_rows > 0) { 
                                
                ?>
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Wall</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" action="add-page-post.php" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                      <div class="form-group">
                        <div class="col-sm-12">
                         <textarea class="form-control" name="description" placeholder="What's on your mind?" name="message"></textarea>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                      </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info">Post</button>
                      <div class="pull-right margin-r-5">
                        <label class="btn btn-warning">Image
                          <input type="file" name="image" id="ProfileImageBtn">
                        </label>
                        
                      </div>
                      <div class="pull-right margin-r-5">
                        <label class="btn btn-warning">Video
                          <input type="file" name="video" id="ProfileVideoBtn" accept=".mp4">
                        </label>
                      </div>
                <div>
                      <div>
                        <?php if(isset($_SESSION['uploadError'])) { ?>
                          <p><?php echo $_SESSION['uploadError']; ?></p>
                        <?php unset($_SESSION['uploadError']); } ?>
                      </div>
                    </div>
                    <!-- /.box-footer -->
                  </form>
                </div>

                <?php } ?>
                
                <?php

                $sql = "SELECT * FROM page_posts INNER JOIN users ON page_posts.id_user=users.id_user WHERE page_posts.id_page='$_GET[id]' ORDER BY page_posts.createdAt DESC";

                $result = $conn->query($sql);

                if($result->num_rows > 0) {
                  while($row =  $result->fetch_assoc()) {
                    ?>
                      <!-- Box Comment -->
                      <div class="box box-widget">
                        <div class="box-header with-border">
                          <div class="user-block">
                            <?php
                          if($row['profileimage'] != '') {
                            echo '<img src="uploads/profile/'.$row['profileimage'].'" class="img-circle img-bordered-sm" alt="User Image">';
                          } else {
                             echo '<img src="dist/img/avatar5.png" class="img-circle img-bordered-sm" alt="User Image">';
                          }
                        ?>
                            <span class="username"><a href="#"><?php echo $row['name']; ?></a></span>
                            <span class="description">Shared publicly - <?php echo date('d-M-Y h:i a', strtotime($row['createdAt'])); ?></span>
                          </div>
                        </div>
                        <div class="box-body">
                        <?php
                          if($row['image'] != "") {
                            echo '<img class="img-responsive pad" src="uploads/pages/'.$row['image'].'" alt="Photo">';
                          }

                          if($row['video'] != "") {
                            ?>
                              <div class="row">
                                <div class="col-xs-12">
                                  <div class="embed-responsive embed-responsive-16by9">
                                    <video src="uploads/pages/<?php echo $row['video']; ?>" controls></video>
                                  </div>
                                </div>
                              </div>
                            <?php
                          }

                          if($row['youtube'] != "") {
                            ?>
                              <div class="row">
                                <div class="col-xs-12">
                                  <div class="embed-responsive embed-responsive-16by9">
                                    <iframe src="https://www.youtube.com/embed/<?php echo $row['youtube']; ?>?rel=0&amp;showinfo=0" class="embed-responsive-item"></iframe>
                                  </div>
                                </div>
                              </div>
                            <?php
                          }
                        ?>
                          

                          <p><?php echo $row['description']; ?></p>
                          
                          <?php

                          $sql1 = "SELECT * FROM page_likes WHERE id_user='$_SESSION[id_user]' AND id_post='$row[id_post]'";
                          $result1 = $conn->query($sql1);

                          if($result1->num_rows > 0) {
                            ?>
                            <button type="button" class="btn btn-default btn-xs" disabled><i class="fa fa-thumbs-o-up"></i> Like</button>

                            <?php
                          } else {
                            ?>
                               <button type="button" id="addLike" data-id="<?php echo $row['id_post']; ?>" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button>
                            <?php
                          }
                          ?>   
                          <?php
                          $sql2 = "SELECT * FROM page_likes WHERE id_post='$row[id_post]'";
                          $result2 = $conn->query($sql2);
                          $totalLikes = (int)$result2->num_rows; 
                          ?>  
                          <?php
                          $sql3 = "SELECT * FROM page_comments WHERE id_post='$row[id_post]'";
                          $result3 = $conn->query($sql3);
                          $totalComments = (int)$result3->num_rows; 
                          ?>                       
                          <span class="pull-right text-muted"><?php echo $totalLikes; ?> likes - <?php echo $totalComments; ?> comments</span>
                        </div>
                        <!-- /.box-body -->
                        <?php
                        $sql4 = "SELECT * FROM page_comments WHERE id_post='$row[id_post]'";
                          $result4 = $conn->query($sql4);
                          if($result4->num_rows > 0) {
                            ?>
                        <div class="box-footer box-comments" style="display: block;">
                        <?php
                          
                            while($row4 = $result4->fetch_assoc()) {
                              $sql5 = "SELECT * FROM users WHERE id_user='$row4[id_user]'";
                              $result5 = $conn->query($sql5);
                              if($result5->num_rows > 0) {
                                $row5 = $result5->fetch_assoc();
                              }
                          ?>

                          <div class="box-comment">
                          <?php
                              if($row5['profileimage'] != "") {
                                echo '<img class="img-circle img-sm" src="uploads/profile/'.$row5['profileimage'].'" alt="Photo">';
                              } else {
                                
                                echo '<img class="img-circle img-sm" src="dist/img/avatar5.png" alt="Photo">';
                              }
                            ?>
                            <div class="comment-text">
                                  <span class="username">
                                    <?php echo $row5['name']; ?>
                                    <span class="text-muted pull-right"><?php echo date('d-M-Y h:i a', strtotime($row4['createdAt'])); ?></span>
                                  </span>
                              <?php echo $row4['comment']; ?>
                            </div>
                          </div>

                          <?php
                          }
                        ?>

                        </div>
                        <?php } ?>
                        <!-- /.box-footer -->
                        
                        <div class="box-footer">
                          <form action="#" method="post" onsubmit="return false;">
                          <?php
                          $sql5 = "SELECT * FROM users WHERE id_user='$_SESSION[id_user]'";
                              $result5 = $conn->query($sql5);
                              if($result5->num_rows > 0) {
                                $row5 = $result5->fetch_assoc();
                              }
                              if($row5['profileimage'] != "") {
                                echo '<img class="img-responsive img-circle img-sm" src="uploads/profile/'.$row5['profileimage'].'" alt="Photo">';
                              } else {
                                echo '<img class="img-responsive img-circle img-sm" src="dist/img/avatar5.png" alt="Photo">';
                              }
                            ?>
                            <!-- .img-push is used to add margin to elements next to floating images -->
                            <div class="img-push">
                              <input type="text" data-id="<?php echo $row['id_post']; ?>" class="addcomment form-control input-sm" onkeypress="checkInput(event, this);" placeholder="Press enter to post comment">
                            </div>
                          </form>
                        </div>
                        <!-- /.box-footer -->
                      </div>
                      <!-- /.box -->
                    <?php
                  }
                }
                ?>
                
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
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

<script>
  $("#addLike").on("click", function() {
    var id_post = $(this).attr("data-id");
    $.post("add-page-like.php", {id:id_post}).done(function(data) {
      var result = $.trim(data);
      if(result == "ok") {
        location.reload();
      }
    });
  });
</script>
<script>
  function checkInput(e, t) {

    //13 means enter
    if(e.keyCode === 13) {
      var id_post = $(t).attr("data-id");
      var comment = $(t).val();
      $.post("add-post-comment.php", {id:id_post, comment:comment}).done(function(data) {
        var result = $.trim(data);
        if(result == "ok") {
          location.reload();
        }
      });
    }
  }
</script>
</body>
</html>
