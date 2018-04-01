<?php

session_start();

if(empty($_SESSION['id_user'])) {
  header("Location: login.php");
  exit();
}

require_once("db.php");

$sql = "SELECT messages.*, users.name, users.profileimage FROM messages INNER JOIN users ON messages.id_from=users.id_user WHERE (id_from='$_SESSION[id_user]' AND id_to='$_GET[id]') OR (id_from='$_GET[id]' AND id_to='$_SESSION[id_user]') ORDER BY messages.createdAt";
  $result = $conn->query($sql);
  if($result->num_rows >  0) { 
    while($row = $result->fetch_assoc()) {
     if($row['id_from'] == $_SESSION['id_user']) { ?>

<!-- Message to the right -->
<div class="direct-chat-msg right">
  <div class="direct-chat-info clearfix">
    <span class="direct-chat-name pull-right"><?php echo $row['name']; ?></span>
    <span class="direct-chat-timestamp pull-left"><?php echo date("d-M-Y h:i a", strtotime($row['createdAt'])); ?></span>
  </div>
  <!-- /.direct-chat-info -->
  <?php if($row['profileimage'] == '') {
    ?>
    <img class="direct-chat-img" src="dist/img/avatar5.png" alt="message user image">
    <?php
  } else { ?>
  <img class="direct-chat-img" src="uploads/profile/<?php echo $row['profileimage']; ?>" alt="message user image">
  <?php } ?>
  <!-- /.direct-chat-img -->
  <div class="direct-chat-text">
    <?php echo $row['message']; ?>
  </div>
  <!-- /.direct-chat-text -->
</div>
<!-- /.direct-chat-msg -->

<?php } else { ?>

<!-- Message. Default to the left -->
<div class="direct-chat-msg">
  <div class="direct-chat-info clearfix">
    <span class="direct-chat-name pull-left"><?php echo $row['name']; ?></span>
    <span class="direct-chat-timestamp pull-right"><?php echo date("d-M-Y h:i a", strtotime($row['createdAt'])); ?></span>
  </div>
  <!-- /.direct-chat-info -->
  <?php if($row['profileimage'] == '') {
    ?>
    <img class="direct-chat-img" src="dist/img/avatar5.png" alt="message user image">
    <?php
  } else { ?>
  <img class="direct-chat-img" src="uploads/profile/<?php echo $row['profileimage']; ?>" alt="message user image">
  <?php } ?>
  <!-- /.direct-chat-img -->
  <div class="direct-chat-text">
    <?php echo $row['message']; ?>
  </div>
  <!-- /.direct-chat-text -->
</div>
<!-- /.direct-chat-msg -->

<?php } } } ?>