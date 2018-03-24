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

$_SESSION['callFrom'] = "messages.php";

$sql = "SELECT id_from FROM messages WHERE id_to='$_SESSION[id_user]' AND viewed='0' GROUP BY id_from";
$result = $conn->query($sql);
if($result->num_rows > 0) {
  $notificationArray = array();
  while($row = $result->fetch_assoc()) {
    array_push($notificationArray, $row['id_from']);
  }
  $notificationArray = json_encode($notificationArray);
}


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
        Messenger
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-12">
          <!-- DIRECT CHAT -->
              <div id="chatButton" class="box box-warning direct-chat direct-chat-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Messenger - <span id="userName"></span></h3>

                  <div class="box-tools pull-right">
                    <?php
                    $sql1 = "SELECT * FROM friends INNER JOIN users ON friends.id_frienduser=users.id_user WHERE friends.id_user='$_SESSION[id_user]'";
                      $result1 = $conn->query($sql1);

                      if($result1->num_rows > 0) { 
                        $totalno = $result1->num_rows;
                      } else {
                        $totalno = 0;
                      }
                    ?>
                    <span data-toggle="tooltip" title="Total Contacts" class="badge bg-yellow"><?php echo $totalno; ?></span>
                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts"
                            data-widget="chat-pane-toggle">
                      <i class="fa fa-comments"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <!-- Conversations are loaded here -->
                  <div id="messagesBody" class="direct-chat-messages">
                    

                  </div>
                  <!--/.direct-chat-messages-->

                  <!-- Contacts are loaded here -->
                  <div class="direct-chat-contacts">
                    <ul class="contacts-list">
                     <?php
                    $sql1 = "SELECT * FROM friends INNER JOIN users ON friends.id_frienduser=users.id_user WHERE friends.id_user='$_SESSION[id_user]'";
                      $result1 = $conn->query($sql1);

                      if($result1->num_rows > 0) { 
                          while($row = $result1->fetch_assoc()) {
                    ?>

                      <li>
                        <a class="getMessages" href="javascript:;" data-id="<?php echo $row['id_user']; ?>" data-href="get-messages.php?id=<?php echo $row['id_user']; ?>">
                          <?php if($row['profileimage'] == '') {
                          ?>
                           <img class="contacts-list-img" src="dist/img/avatar5.png" alt="User Image">
                          <?php
                        } else { ?>
                         <img class="contacts-list-img" src="uploads/profile/<?php echo $row['profileimage']; ?>" alt="User Image">
                        <?php } ?>
                         

                          <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  <?php echo $row['name']; ?>
                                  <small class="contacts-list-date pull-right"><?php if($row['online'] == '1') { echo 'Online'; } else { echo 'Offline'; } ?></small>
                                </span>
                            <span class="contacts-list-msg"><?php echo $row['designation']; ?></span>
                          </div>
                          <!-- /.contacts-list-info -->
                        </a>
                      </li>
                      <!-- End Contact Item -->

                      <?php } } ?>

                    </ul>
                    <!-- /.contatcts-list -->
                  </div>
                  <!-- /.direct-chat-pane -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <form id="sendMessage">
                    <div class="input-group">
                      <input id="messageInput" type="text" name="message" placeholder="Type Message ..." autocomplete="off" class="form-control">
                      <span class="input-group-btn">
                            <button id="sendBtn" type="submit" class="btn btn-warning btn-flat">Send</button>
                          </span>
                    </div>
                  </form>
                </div>
                <!-- /.box-footer-->
              </div>
              <!--/.direct-chat -->
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
<script>
  var id_user;

  <?php if(empty($notificationArray)) { ?>
  var notificationArray = [];
  <?php } else { ?>
    var notificationArray = '<?php echo $notificationArray; ?>';
  <?php } ?>
  
  $(function() {

    

    checkIdUser();

    $('.getMessages').on("click", function() {
      id_user = $(this).attr('data-id');
      var dataUrl = $(this).attr('data-href');
      $("#messagesBody").load(dataUrl, function() {
            $("#messagesBody").scrollTop($("#messagesBody")[0].scrollHeight);
          });
      $("#chatButton").attr('class', 'box box-warning direct-chat direct-chat-warning');
      checkIdUser();
    });


    $("#sendMessage").on("submit", function(e) {
      e.preventDefault();
      var message = $("#messageInput").val();
      $.post("addmessage.php", {message: message, id_user:id_user}).done(function(data) {
        var result = $.trim(data);
        if(result == "ok") {
          $("#messageInput").val('');
          $("#messagesBody").load("get-messages.php?id="+id_user, function() {
            $("#messagesBody").scrollTop($("#messagesBody")[0].scrollHeight);
          });
        }
      });
    });
    
    

  });
</script>
<script>
  function checkIdUser () {
    if(id_user == undefined) {
      $("#messageInput").prop('disabled', true);
      $("#sendBtn").prop('disabled', true);
    } else {
      $("#messageInput").prop('disabled', false);
      $("#sendBtn").prop('disabled', false);
      getUsername();
      notificationRead();
    }
  }
  function getUsername() {
    $.post("get-message-name.php", {id:id_user}).done(function(data) {
      $("#userName").text(data);
    });
  }
  function notificationRead() {
    // check if id_user exists in notification array or not.
    if(notificationArray.indexOf(id_user) > -1) { 
      // if id_user is not in notification array then it will return -1 and the condition will become false
      $.post("message-notification.php", { id:id_user}).done(function(data) {
        $("#header").load(location.href + " #header");
      });
    }
  }
</script>
<?php
if(isset($_GET['id'])) {

  $sql1 = "SELECT * FROM friends WHERE id_user='$_SESSION[id_user]' AND id_frienduser='$_GET[id]'";
  $result1 = $conn->query($sql1);
    if($result1->num_rows > 0) { 
    ?>
      <script>
      $(function() {
       id_user = "<?php echo $_GET['id']; ?>";
          $("#messagesBody").load("get-messages.php?id="+id_user, function() {
            $("#messagesBody").scrollTop($("#messagesBody")[0].scrollHeight);
          });
      checkIdUser();
      });
    </script>
      <?php 
  } else {
    header("Location: friends.php");
    exit();
  }

} else {
  $sql1 = "SELECT * FROM messages WHERE id_from='$_SESSION[id_user]' ORDER BY id_message DESC LIMIT 1";
    $result1 = $conn->query($sql1);
    if($result1->num_rows > 0) { 
        $row = $result1->fetch_assoc();
  ?>
  <script>
  $(function() {
   id_user = "<?php echo $row['id_to']; ?>";
      $("#messagesBody").load("get-messages.php?id="+id_user, function() {
        $("#messagesBody").scrollTop($("#messagesBody")[0].scrollHeight);
      });
  checkIdUser();
  });
</script>
<?php 
  }

} 
?>
</body>
</html>
