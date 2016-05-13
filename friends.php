<?php
include('includes/template.php');
$name=$_SESSION['login_user'];
$req=$_GET['Req'];
$sql="select count(id) from mysql.friends where id2='".$id."' and Request_Status = 1";
$res=mysqli_query($con,$sql);
$row = mysqli_fetch_row($res);
if($row[0]==0){
$friends=0;
}else{
$friends = $row[0]-1;
}
$sql="select id from mysql.friends where id2='".$id."' and Request_Status=1";
$res=mysqli_query($con,$sql);
$sql2="select id2 from mysql.friends where id='".$id."' and Request_Status = 0";
$resul=mysqli_query($con,$sql2);
?>
<!DOCTYPE html>
<html>
<body>
<main>
<center>
  <br>
  <br>
  <br>
  <br>
  <br>
<div class="Feeds" style="background-color:white;">
<br>
<h2>You have <?php echo $friends; ?> Friend(s)</h2>
</div>
<br>
<br>
<?php
while($res1=mysqli_fetch_array($res,MYSQLI_NUM)){
$id2=$res1[0];
$sql="select username,name,email from mysql.registration_zany where id='".$id2."'";
$res1=mysqli_query($con,$sql);
$row=mysqli_fetch_assoc($res1);
  if($row["username"]!=$_SESSION['login_user']){
  echo "<div class='row'>
    <div class='col-xs-6 col-md-4'>
      <div class='thumbnail'>
  UserName:".$row["username"]."<br>Profile:".$row["name"]."<br>E-mail:".$row["email"]."
  <br><button class='btn btn-danger' role='button'>
  Unfriend</button></div></div>";
}}
 ?>
 </div>
 <hr>
 <div style="margin-left:10px;">
 <?php
 if($req){
   while($res2=mysqli_fetch_array($resul,MYSQLI_NUM)){
   $id3=$res2[0];
   $sql1="select id,username,name,email from mysql.registration_zany where id='".$id3."'";
   $res2=mysqli_query($con,$sql1);
   $frow=mysqli_fetch_assoc($res2);
     if($frow["username"]!=$_SESSION['login_user']){

     echo "<div class='row'>
       <div class='col-xs-6 col-md-4'>
         <div class='thumbnail'>
     UserName:".$frow["username"]."<br>Profile:".$frow["name"]."<br>E-mail:".$frow["email"]."
     <br><form action='myreq.php' method='post'><input type='submit' class='btn btn-primary' name='accept' value='Accept'>
     <input name='action' type='hidden' value='".$id3."' >
     </form><form action='decline.php' method='post'>
     <input name='action' type='hidden' value='".$id3."' >
     &nbsp;<input type='submit' class='btn btn-warning' name='decline' value='Decline'></form></div></div>";
   }}}
    ?>
  </div>
    </div>
</center></main>
</body>
</html>
