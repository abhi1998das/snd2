<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      
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