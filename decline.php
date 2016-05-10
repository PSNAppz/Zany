<?php
include('includes/template.php');
if(isset($_POST['action'])){
  $ReqID=$_POST['action'];
  $sql2="delete from mysql.friends where id2=".$ReqID." and id=".$id;
  mysqli_query($con,$sql2);
}
header("Location: friends.php");

?>
