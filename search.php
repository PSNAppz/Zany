<?php
include('includes/template.php');
$user=$_SESSION['login_user'];

    if(isset($_POST['action'])){
    if($_POST['action']=="searchb"){
      $query=secure_input($_POST['searchbox']);
                      if(!empty($query)){
                        $sql="select id,username, name, email from mysql.registration_zany where name like '".$query."%' and privacy=0";
           				      $res=mysqli_query($con,$sql);
                     $resmsg="<div class='alert alert-success' role='alert'>SEARCH RESULTS FOR :<b>".$query."</b></div>";
                 }
          }
    }
?>
<style>
#searcharea{
color:white;
}
#row{
margin-left: 20%;
margin-right: 20%;
}
</style>
<main>
<center style="left:30px;">
  <br>
  <br>
<div id="searcharea">
  <h3> Find Your Friends on Zany and Connect with them to see their updates.</h3><br><br>
  <center style="margin-left:45%;">
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
  <div class="row">
    <div class="col-lg-6">
      <div class="input-group">
        <span class="input-group-btn">
          <input class="btn btn-default" type="submit" name="search" value="Search">
        </span>
        <input name="action" type="hidden" value="searchb" >
        <input type="text" class="form-control" name="searchbox" placeholder="Search Name" pattern=".{3,}"  required title="3 characters minimum">
      </div>
    </div>
  </div>
</form>
</center>
</div>
<?php echo $resmsg; ?>
<div id="row">
  <?php
  $sql2="select id from mysql.friends where id2='".$id."' and Request_Status=1  and id !=".$id;
  $res2=mysqli_query($con,$sql2);
  $sql3="select id from mysql.friends where id2='".$id."' and Request_Status=0";
  $res3=mysqli_query($con,$sql3);
  while($row=mysqli_fetch_array($res,MYSQLI_NUM)){
    $flag=0;
    $flag1=0;
    while($reqs=mysqli_fetch_array($res3,MYSQLI_NUM)){
      if($reqs[0]==$row[0]){
        $flag1=1;
      }
    }
      while($fr=mysqli_fetch_array($res2,MYSQLI_NUM)){
    if($fr[0]==$row[0]){
      $flag=1;
    }
  }
mysqli_free_result($res2);
$sql2="select id from mysql.friends where id2='".$id."' and Request_Status=1  and id !=".$id;
$res2=mysqli_query($con,$sql2);
mysqli_free_result($res3);
$sql3="select id from mysql.friends where id2='".$id."' and Request_Status=0";
$res3=mysqli_query($con,$sql3);
if($flag){
  $table="<div class='row'>
    <div class='col-xs-6 col-md-4'>
      <div class='thumbnail'>
  UserName:".$row[1]."<br>Profile:".$row[2]."<br>E-mail:".$row[3]."
  <p><span class='label label-info'>Friend</span></p></div></div>";
  echo $table;
}
elseif ($flag1) {
  $table="<div class='row'>
    <div class='col-xs-6 col-md-4'>
      <div class='thumbnail'>
  UserName:".$row[1]."<br>Profile:".$row[2]."<br>E-mail:".$row[3]."
  <p><span class='label label-warning'>Request Pending</span></p></div></div>";
  echo $table;
}
else{
$table="<div class='row'>
  <div class='col-xs-6 col-md-4'>
    <div class='thumbnail'>
UserName:".$row[1]."<br>Profile:".$row[2]."<br>E-mail:".$row[3]."
<p><form action='request.php' method='post'>
<input name='action' type='hidden' value='".$row[0]."' >
<input type='submit' class='btn btn-primary' name='req' value='Send Request'>
</form></p></div></div>";
echo $table;
}
}
  ?>
</div>
</div>
</div>
</main>
</center>
