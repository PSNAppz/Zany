<?php
include('includes/template.php');
if(isset($_POST['action'])){
  $ReqID=$_POST['action'];

  $sql2="update mysql.friends set Request_Status = 1 where id2 = ".$ReqID." and id = ".$id;
  mysqli_query($con,$sql2);
  $sql="insert into mysql.friends (id2, id, Request_Status) values (".$id.",".$ReqID.",1)";
  $rs=mysqli_query($con,$sql);

}
header("Location: friends.php");

?>
