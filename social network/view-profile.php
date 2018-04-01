<?php

session_start();

if(empty($_SESSION['id_user'])) {
  header("Location: login.php");
  exit();
}

if(empty($_GET['id'])) {
  header("Location: friends.php");
  exit();
} else {
  if($_GET['id'] == $_SESSION['id_user']) {
    header("Location: friends.php");
    exit();
  }
}


require_once("db.php");

$name = $designation = $email = $degree = $university = $city = $country = $skills = $aboutme = $profileimage =  "";

$sql = "SELECT * FROM users WHERE id_user='$_GET[id]'";
$result = $conn->query($sql);

if($result->num_rows > 0) { 
  while($row = $result->fetch_assoc()) {
    $name = $row['name'];
    $designation = $row['designation'];
    $email = $row['email'];
    $degree = $row['degree'];
    $university = $row['university'];
    $city = $row['city'];
    $country = $row['country'];
    $skills= $row['skills'];
    $aboutme = $row['aboutme'];
    $profileimage = $row['profileimage'];
   
  }
}

$_SESSION['callFrom'] = "view-profile.php?id=".$_GET['id'];

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
    <section class="content-header">
      <h1>
        User Profile
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
            <?php 
                $sql = "SELECT * FROM users WHERE id_user='$_GET[id]'";
                $result = $conn->query($sql);
                if($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  if($row['profileimage'] != '') {
                    echo '<img src="uploads/profile/'.$row['profileimage'].'" class="profile-user-img img-responsive img-circle" alt="User Image">';
                  } else {
                     echo '<img src="dist/img/avatar5.png" class="profile-user-img img-responsive img-circle" alt="User Image">';
                  }
                }
                ?>

              <h3 class="profile-username text-center"><?php echo $name; ?></h3>

              <p class="text-muted text-center"><?php echo $designation; ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <?php
                   $sql1 = "SELECT * FROM user_followers WHERE id_userfollower='$_GET[id]'";
                    $result1 = $conn->query($sql1);
                    if($result1->num_rows > 0) {
                      $totalno = $result1->num_rows;
                    } else {
                      $totalno = 0;
                    }
                  ?>
                  <b>Followers</b> <a class="pull-right"><?php echo $totalno; ?></a>
                </li>
                <li class="list-group-item">
                <?php
                   $sql1 = "SELECT * FROM user_followers WHERE id_user='$_GET[id]'";
                    $result1 = $conn->query($sql1);
                    if($result1->num_rows > 0) {
                      $totalno = $result1->num_rows;
                    } else {
                      $totalno = 0;
                    }
                  ?>
                  <b>Following</b> <a class="pull-right"><?php echo $totalno; ?></a>
                </li>
                <li class="list-group-item">
                   <?php
                   $sql1 = "SELECT * FROM friends WHERE id_user='$_GET[id]'";
                    $result1 = $conn->query($sql1);
                    if($result1->num_rows > 0) {
                      $totalno = $result1->num_rows;
                    } else {
                      $totalno = 0;
                    }
                  ?>
                  <b>Friends</b> <a class="pull-right"><?php echo $totalno; ?></a>
                </li>
              </ul>
              <?php
                $sql1 = "SELECT * FROM user_followers WHERE id_user='$_SESSION[id_user]' AND id_userfollower='$_GET[id]'";
                $result1 = $conn->query($sql1);
                if($result1->num_rows == 0) {
              ?>
                  <a href="user-follow.php?id=<?php echo $_GET['id']; ?>" class="btn btn-primary btn-block"><b>Follow</b></a>
              <?php } else { ?>
                  <a href="user-unfollow.php?id=<?php echo $_GET['id']; ?>" class="btn btn-danger btn-block"><b>UnFollow</b></a>
              <?php } ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Education</strong>
              
              <?php if($degree != "" && $university != "") { ?>
              <p class="text-muted">
                <?php echo $degree; ?> from <?php echo $university; ?>
              </p>
              <?php  } ?>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted"><?php echo $city; ?>, <?php echo $country; ?></p>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
              
              <p>
              <?php 

              $arr = explode(" ", $skills);

              $colors = array("label-danger", "label-success", "label-info", "label label-warning", "label-primary");

              foreach ($arr as $key => $value) {
                $c = array_rand($colors);
                $v = $colors[$c];
                ?>
                <span class="label <?php echo $v; ?>"><?php echo $value; ?></span>
                <?php
              } 
              ?>
              </p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> About Me</strong>

              <p><?php echo $aboutme; ?></p>
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
                $sql1 = "SELECT * FROM friends WHERE id_user='$_SESSION[id_user]' AND id_frienduser='$_GET[id]'";
                  $result1 = $conn->query($sql1);

                  if($result1->num_rows > 0) { 
                                
                ?>
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Wall</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" action="add-friend-post.php" method="post" enctype="multipart/form-data">
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
                          <input type="file" name="image" id="ProfileImageBtn" accept=".png, .jpg, .jpeg">
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

                <?php } ?>
                
                <?php

                $sql = "SELECT * FROM ( SELECT post.id_post, post.id_user, post.description, post.image, post.createdAt, post.video, post.youtube, users.name, users.profileimage, 'user' as type FROM post INNER JOIN users ON post.id_user=users.id_user WHERE post.id_user='$_GET[id]' UNION SELECT friend_posts.id_post, friend_posts.id_user, friend_posts.description, friend_posts.image, friend_posts.createdAt, friend_posts.video, friend_posts.youtube, users.name, users.profileimage, 'friend' as type FROM friend_posts INNER JOIN users ON friend_posts.id_user=users.id_user WHERE friend_posts.id_friend='$_GET[id]' ) posts ORDER BY posts.createdAt DESC";

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
                            echo '<img class="img-responsive pad" src="uploads/post/'.$row['image'].'" alt="Photo">';
                          }

                          if($row['video'] != "") {
                            ?>
                            <div class="row">
                              <div class="col-xs-12">
                                <div class="embed-responsive embed-responsive-16by9">
                                  <video class="video" src="uploads/post/<?php echo $row['video']; ?>" controls></video>
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
                                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $row['youtube']; ?>?rel=0&amp;showinfo=0"></iframe>
                                </div>
                              </div>
                            </div>
                            <?php
                          }
                        ?>
                          

                          <p><?php echo $row['description']; ?></p>
                          <?php
                          $sql1 = "SELECT * FROM friends WHERE id_user='$_SESSION[id_user]' AND id_frienduser='$_GET[id]'";
                            $result1 = $conn->query($sql1);

                            if($result1->num_rows > 0) { 
                                          
                          ?>
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
                          <span class="pull-right text-muted"><?php echo $totalLikes; ?> likes - <?php echo $totalComments; ?> comments</span>
                        </div>
                        <!-- /.box-body -->
                        <?php if($totalComments > 0) { ?>
                        <div class="box-footer box-comments" style="display: block;">
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
                        <?php
                          $sql1 = "SELECT * FROM friends WHERE id_user='$_SESSION[id_user]' AND id_frienduser='$_GET[id]'";
                            $result1 = $conn->query($sql1);

                            if($result1->num_rows > 0) { 
                                          
                          ?>
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
                              <input type="text" id="addcomment" data-id="<?php echo $row['id_post']; ?>" data-type="<?php echo $row['type']; ?>" class="form-control input-sm" onkeypress="checkInput(event, this);" placeholder="Press enter to post comment">
                            </div>
                          </form>
                        </div>
                        <!-- /.box-footer -->
                        <?php } ?>
                      </div>
                      <!-- /.box -->
                    <?php
                  }
                }
                ?>
                
<!--
                <div class="post">
                  <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="dist/img/user6-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Adam Jones</a>
                        </span>
                    <span class="description">Posted 5 photos - 5 days ago</span>
                  </div>
                  <div class="row margin-bottom">
                    <div class="col-sm-6">
                      <img class="img-responsive" src="dist/img/photo1.png" alt="Photo">
                    </div>
                    <div class="col-sm-6">
                      <div class="row">
                        <div class="col-sm-6">
                          <img class="img-responsive" src="dist/img/photo2.png" alt="Photo">
                          <br>
                          <img class="img-responsive" src="dist/img/photo3.jpg" alt="Photo">
                        </div>
                        <div class="col-sm-6">
                          <img class="img-responsive" src="dist/img/photo4.jpg" alt="Photo">
                          <br>
                          <img class="img-responsive" src="dist/img/photo1.png" alt="Photo">
                        </div>
                      </div>
                    </div>
                  </div>

                  <ul class="list-inline">
                    <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                    <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                    </li>
                    <li class="pull-right">
                      <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                        (5)</a></li>
                  </ul>

                  <input class="form-control input-sm" type="text" placeholder="Type a comment">
                </div>
                 -->
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
</body>
</html>
