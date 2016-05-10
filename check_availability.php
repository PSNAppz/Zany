<?php
include('includes/mysql_connection.php');

if(!empty($_POST["username"])) {
  $sql="select count(*) from mysql.registration_zany where username='".$_POST["username"]."'";
  $res=mysqli_query($con,$sql);
  $row = mysqli_fetch_row($res);
  $user_count = $row[0];
  if($user_count>0) {
      echo "<span class='label label-danger'> Username Not Available</span>";
  }else{
      echo "<span class='label label-success'> Username Available</span>";
  }
}
?>
