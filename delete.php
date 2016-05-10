<?php
include('includes/session.php');
include('includes/mysql_connection.php');
if(isset($_GET['ID']))
{
  $user=$_SESSION['login_user'];
  $sql="select id from mysql.registration_zany where username='".$user."'";
  $res=mysqli_query($con,$sql);
  $res1=mysqli_fetch_assoc($res);
  $id=$res1["id"];
  $postID=$_GET['ID'];
  $sql="update mysql.points set usr_pts='1' where pstid='".$postID."'";
  $res=mysqli_query($con,$sql);
}
else{
echo "Damn";
}
 ?>
