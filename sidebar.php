<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php 
                $sql = "SELECT * FROM users WHERE id_user='$_SESSION[id_user]'";
                $result = $conn->query($sql);
                if($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  if($row['profileimage'] != '') {
                    echo '<img src="uploads/profile/'.$row['profileimage'].'" class="img-circle" alt="User Image">';
                  } else {
                    echo '<img src="dist/img/avatar5.png" class="img-circle" alt="User Image">';
                  }
                  $username = $row['name'];
                }
                ?>
        </div>
        <div class="pull-left info">
          <p><?php echo $username; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu  -->
      <ul class="sidebar-menu" data-widget="tree">
        <li <?php if($_SESSION['callFrom'] == "profile.php") { echo 'class="active"'; } ?>>
          <a href="profile.php">
            <i class="fa fa-user-o"></i> <span>Profile</span>
          </a>
        </li>
        <li <?php if($_SESSION['callFrom'] == "index.php") { echo 'class="active"'; } ?>>
          <a href="index.php">
            <i class="fa fa-newspaper-o"></i> <span>News Feed</span>
          </a>
        </li>
        <li <?php if($_SESSION['callFrom'] == "messages.php") { echo 'class="active"'; } ?>>
          <a href="messages.php">
            <i class="fa fa-wechat"></i> <span>Messages</span>
          </a>
        </li>
        <li <?php if($_SESSION['callFrom'] == "friends.php") { echo 'class="active"'; } ?>>
          <a href="friends.php">
            <i class="fa fa-users"></i> <span>Friends</span>
          </a>
        </li>
        <li <?php if($_SESSION['callFrom'] == "friend-request.php") { echo 'class="active"'; } ?>>
          <a href="friend-request.php">
            <i class="fa fa-users"></i> <span>Friend Request</span>
          </a>
        </li>
        <li <?php if($_SESSION['callFrom'] == "pages.php") { echo 'class="active"'; } ?>>
          <a href="pages.php">
            <i class="fa fa-file-o"></i> <span>Pages</span>
          </a>
        </li>
        <li <?php if($_SESSION['callFrom'] == "events.php") { echo 'class="active"'; } ?>>
          <a href="events.php">
            <i class="fa fa-calendar"></i> <span>Events</span>
          </a>
        </li>
        <li>
          <a href="photos.php">
            <i class="fa  fa-file-photo-o"></i> <span>Photos</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>