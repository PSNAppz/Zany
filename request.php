<?php
include('includes/template.php');
if(isset($_POST['action'])){
  $ReqID=$_POST['action'];
  $sql="insert into mysql.friends (id2, id, Request_Status) values (".$id.",".$ReqID.",0)";
  mysqli_query($con,$sql);
}
header("Location: search.php");

?>
