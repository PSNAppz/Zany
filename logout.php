<?php
include('includes/mysql_connection.php');
session_start();
$sql="update mysql.registration_zany set Online='0' where username='".$_SESSION['login_user']."'";
$res=mysqli_query($con,$sql);
session_destroy();
header('Location: index.php');
?>
