<?php

session_start();

if(empty($_SESSION['id_user'])) {
  header("Location: login.php");
  exit();
}

require_once("db.php");

$name = $designation = $profileimage = "";

$sql = "SELECT * FROM users WHERE id_user='$_SESSION[id_user]'";
$result = $conn->query($sql);

if($result->num_rows > 0) { 
  while($row = $result->fetch_assoc()) {
    $name = $row['name'];
    $designation = $row['designation'];
    $profileimage = $row['profileimage'];
  }
}

$_SESSION['callFrom'] = "index.php";

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

    <section class="content-header">
      <h1>
        News Feed
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-8 col-sm-6 col-xs-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Wall</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="addpost.php" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <div class="col-sm-12">
                   <textarea class="form-control" name="description" placeholder="What's on your mind?" name="message"></textarea>
                  </div>
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
                  <?php if(isset($_SESSION['uploadError'])) { ?>
                    <p><?php echo $_SESSION['uploadError']; ?></p>
                  <?php unset($_SESSION['uploadError']); } ?>
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>

          <?php

                $sql = "SELECT * FROM ( SELECT post.id_post, post.id_user, post.description, post.image, post.createdAt, post.video, post.youtube, users.name, users.profileimage, 'user' as type FROM post INNER JOIN users ON post.id_user=users.id_user WHERE post.id_user='$_SESSION[id_user]' UNION SELECT friend_posts.id_post, friend_posts.id_user, friend_posts.description, friend_posts.image, friend_posts.createdAt, friend_posts.video, friend_posts.youtube, users.name, users.profileimage, 'friend' as type FROM friend_posts INNER JOIN users ON friend_posts.id_user=users.id_user WHERE friend_posts.id_friend='$_SESSION[id_user]' ) posts ORDER BY posts.createdAt DESC";
                $result = $conn->query($sql);

                if($result->num_rows > 0) {
                  $i = 0;
                  while($row =  $result->fetch_assoc()) {
                    $i++;
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
                            echo '<img class="img-responsive pad" src="uploads/post/'.$row['image'].'" alt="Photo">';
                          }

                          if($row['video'] != "") {
                            ?>
                              <div class="row">
                                <div class="col-xs-12">
                                  <div class="embed-responsive embed-responsive-16by9">
                                    <video src="uploads/post/<?php echo $row['video']; ?>" controls></video>
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
                          $sql1 = "SELECT * FROM likes WHERE id_user='$_SESSION[id_user]' AND id_post='$row[id_post]'";
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
                          $sql2 = "SELECT * FROM likes WHERE id_post='$row[id_post]'";
                          $result2 = $conn->query($sql2);
                          $totalLikes = (int)$result2->num_rows; 
                          ?>  
                          <?php
                          if($row['type'] == 'friend') {
                            $sql3="SELECT * FROM friends_comments WHERE id_post='$row[id_post]'";
                          } else {
                            $sql3="SELECT * FROM comments WHERE id_post='$row[id_post]'";
                          }
                          $result3 = $conn->query($sql3);
                          $totalComments = (int)$result3->num_rows; 
                          ?>                       
                          <span class="pull-right text-muted commentBtn" onclick="toggleComments(<?php echo $i; ?>);"><?php echo $totalLikes; ?> likes - <?php echo $totalComments; ?> comments</span>
                        </div>
                        <!-- /.box-body -->
                        <?php if($totalComments > 0) { ?>
                        <div id="boxComment<?php echo $i; ?>" class="box-footer box-comments">
                        <?php
                         if($row['type'] == 'friend') {
                            $sql4="SELECT * FROM friends_comments WHERE id_post='$row[id_post]' ORDER BY createdAt";
                          } else {
                            $sql4="SELECT * FROM comments WHERE id_post='$row[id_post]' ORDER BY createdAt";
                          }
                          $result4 = $conn->query($sql4);

                          if($result4->num_rows > 0) {
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
                        }
                        ?>

                        </div>
                        <?php } ?>
                        <!-- /.box-footer -->
                        <div class="box-footer">
                          <form action="#" method="post" onsubmit="return false;">
                          <?php
                              if($profileimage != "") {
                                echo '<img class="img-responsive img-circle img-sm" src="uploads/profile/'.$profileimage.'" alt="Photo">';
                              } else {
                             echo '<img src="dist/img/avatar5.png" class="img-responsive img-circle img-sm" alt="User Image">';
                          }
                            ?>
                            <!-- .img-push is used to add margin to elements next to floating images -->
                            <div class="img-push">
                              <input type="text" data-id="<?php echo $row['id_post']; ?>" data-type="<?php echo $row['type']; ?>" class="addcomment form-control input-sm" onkeypress="checkInput(event, this);" placeholder="Press enter to post comment">
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

        <div class="col-md-4">
          <!-- USERS LIST -->
          <?php
                $sql1 = "SELECT * FROM friends INNER JOIN users ON friends.id_frienduser=users.id_user WHERE friends.id_user='$_SESSION[id_user]' AND users.online='1'";
                  $result1 = $conn->query($sql1);

                  if($result1->num_rows > 0) { 
                ?>
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">My Online Friends</h3>
              
              <div class="box-tools pull-right">
                <span class="label label-success"><?php echo $result1->num_rows; ?> Online</span>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <ul class="users-list clearfix">
                

                <?php
                      while($row = $result1->fetch_assoc()) {
                ?>
                <li>
                  <?php if($row['profileimage'] == '') {
                    ?>
                     <img src="dist/img/avatar5.png" alt="User Image">
                    <?php
                  } else { ?>
                   <img src="uploads/profile/<?php echo $row['profileimage']; ?>" alt="User Image">
                  <?php } ?>
                  
                  <a class="users-list-name" href="view-profile.php?id=<?php echo $row['id_user']; ?>"><?php echo $row['name']; ?></a>
                </li>
                <?php } ?>
              </ul>
              <!-- /.users-list -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="friends.php" class="uppercase">View All Users</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!--/.box -->
        <?php } ?>
          <!-- USERS LIST -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">All Friends</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <ul class="users-list clearfix">
                <?php
                $sql1 = "SELECT * FROM friends INNER JOIN users ON friends.id_frienduser=users.id_user WHERE friends.id_user='$_SESSION[id_user]'";
                  $result1 = $conn->query($sql1);

                  if($result1->num_rows > 0) { 
                      while($row = $result1->fetch_assoc()) {
                ?>
                <li>
                  <?php if($row['profileimage'] == '') {
                    ?>
                     <img src="dist/img/avatar5.png" alt="User Image">
                    <?php
                  } else { ?>
                   <img src="uploads/profile/<?php echo $row['profileimage']; ?>" alt="User Image">
                  <?php } ?>
                  <a class="users-list-name" href="view-profile.php?id=<?php echo $row['id_user']; ?>"><?php echo $row['name']; ?></a>
                </li>
                <?php } } ?>
              </ul>
              <!-- /.users-list -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="friends.php" class="uppercase">View All Users</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!--/.box -->

          <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Suggested Pages</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">

                <?php 
                $sql = "SELECT * FROM pages ORDER BY RAND() LIMIT 4";
                $result = $conn->query($sql);
                if($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                    $sql1 = "SELECT * FROM page_followers WHERE id_page='$row[id_page]'";
                    $result1 = $conn->query($sql1);
                    if($result1->num_rows > 0) {
                      $totalno = $result1->num_rows;
                    } else {
                      $totalno = 0;
                    }

                    $colors = ['label-success', 'label-warning', 'label-info', 'label-danger', 'label-primary'];

                    $key = array_rand($colors);
                    $colorValue = $colors[$key];
                ?>

                <li class="item">
                  <div class="product-img">
                    <img src="uploads/pages/<?php echo $row['logo']; ?>" alt="Product Image">
                  </div>
                  <div class="product-info">
                    <a href="view-page.php?id=<?php echo $row['id_page']; ?>" class="product-title"><?php echo $row['name']; ?>
                      <span class="label <?php echo $colorValue; ?> pull-right"><?php echo $totalno; ?> Followers</span></a>
                    <span class="product-description">
                          <?php echo $row['description']; ?>
                        </span>
                  </div>
                </li>

                <?php } } ?>

                
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="pages.php" class="uppercase">View All Pages</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->


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
    $.post("addlike.php", {id:id_post}).done(function(data) {
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
      var type = $(t).attr("data-type");
      var comment = $(t).val();
      var user = '<?php echo $_SESSION["id_user"]; ?>';
      if(type=="friend") {
        $.post("add-friends-comments.php", {id:id_post, comment:comment, user:user}).done(function(data) {
          var result = $.trim(data);
          if(result == "ok") {
            location.reload();
          }
        });
      } else {
        $.post("addcomment.php", {id:id_post, comment:comment, user:user}).done(function(data) {
          var result = $.trim(data);
          console.log(data);
          if(result == "ok") {
            location.reload();
          }
        });
      }
      return false;
    }
  }
</script>

<script>
  function toggleComments(id) {
    $("#boxComment"+id).slideToggle("slow");
  }
</script>
</body>
</html>
