  <header id="header" class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>N</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Social </b>Network</span>
    </a>

    <?php

    $sql = "SELECT id_from, COUNT(id_from) as total FROM messages WHERE id_to='$_SESSION[id_user]' AND viewed='0' GROUP BY id_from";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
      $totalUnreadMessages =  $result->num_rows;
    } else {
      $totalUnreadMessages = 0;
    }

    ?>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
                   <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <?php if($totalUnreadMessages > 0) { ?>
              <span class="label label-warning"><?php echo $totalUnreadMessages; ?></span>
              <?php } ?>
            </a>
            <?php if($totalUnreadMessages > 0) { ?>
            <ul class="dropdown-menu">
              <li class="header">You have <?php echo $totalUnreadMessages; ?> notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php
                  while($row = $result->fetch_assoc()) {
                    $sqlUser = "SELECT name FROM users WHERE id_user='$row[id_from]'";
                    $resultUser = $conn->query($sqlUser);
                    $rowName = $resultUser->fetch_assoc();
                  ?>

                  <li>
                    <a href="messages.php?id=<?php echo $row['id_from']; ?>" style="white-space: inherit;">
                      <i class="fa fa-user text-red"></i> You have <?php echo $row['total']; ?> unread message(s) from <?php echo $rowName['name']; ?>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
              </li>
            </ul>
            <?php } else { ?>
            <ul class="dropdown-menu">
              <li class="header">You have 0 notifications</li>
            </ul>
            <?php } ?>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php 
                $sql = "SELECT * FROM users WHERE id_user='$_SESSION[id_user]'";
                $result = $conn->query($sql);
                if($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  if($row['profileimage'] != '') {
                    echo '<img src="uploads/profile/'.$row['profileimage'].'" class="img-circle" alt="User Image" style="width: 25px; height: 25px;">';
                  } else {
                     echo '<img src="dist/img/avatar5.png" class="img-circle" alt="User Image" style="width: 25px; height: 25px;">';
                  }
                  $username = $row['name'];
                }
                ?>
              <span class="hidden-xs"><?php echo $username; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">

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
                }
                ?>
             

                <p>
                  <?php echo $name; ?> - <?php echo $designation; ?>
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>