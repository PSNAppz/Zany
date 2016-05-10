<?php
include('includes/template.php');
$msg="";
if(isset($_POST['action'])){
if($_POST['action']=="status"){
  $name=$_SESSION['login_user'];
  $sql="select id from mysql.registration_zany where username='".$name."'";
  $res=mysqli_query($con,$sql);
  $res1=mysqli_fetch_assoc($res);
  $id=$res1["id"];
$msg=secure_input($_POST['status']);
$sql="insert into mysql.status (id, msg) values('".$id."','".$msg."')";
mysqli_query($con,$sql);
$postID=mysqli_insert_id($con);
$sql="insert into mysql.points (uid,pstid,usr_pts) values(".$id.",".$postID.",0)";
$res=mysqli_query($con,$sql);
}
}
$name=$_SESSION['login_user'];
$sql="select id from mysql.registration_zany where username='".$name."'";
$res=mysqli_query($con,$sql);
$res1=mysqli_fetch_assoc($res);
$id=$res1["id"];
$sql="select id from mysql.friends where id2='".$id."' and Request_Status ='1'";
$result=mysqli_query($con,$sql);
?>
<!DOCTYPE html>
<html>
<body>
<main>
<center>
  <br>
<div id="Main_Content">
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
  <textarea placeholder="Update Status..." cols="100" rows="8" name="status" id="Post-Txt" ></textarea>
  <br>
  <input name="action" type="hidden" value="status" >
  <input type="submit" class="btn btn-info" value="Post Status">
</form>
</div>
<br>
<hr>
<div>
<?php
while($rows=mysqli_fetch_array($result,MYSQLI_NUM))
 {
   $sql="select stid,msg,date from mysql.status where id='".$rows[0]."' order by date DESC";
   $stat=mysqli_query($con,$sql);
   while($stat1=mysqli_fetch_array($stat,MYSQLI_NUM)){
   $postID=$stat1[0];
   $post=$stat1[1];
   $date=$stat1[2];
   $sql2="select username from mysql.registration_zany where id='".$rows[0]."'";
   $stat2=mysqli_query($con,$sql2);
   $stat3=mysqli_fetch_assoc($stat2);
   $nme=$stat3["username"];
   if($rows[0]==1){
     $label="<span class='label label-danger'>Admin</span>";
   }
   else{
     $label="<span class='label label-success'>Moderator</span>";
   }
   #If the post is by the current logged in user delete button is shown.
   if(($nme==$_SESSION['login_user'] && $_SESSION['login_user']!='PSN') && ($nme==$_SESSION['login_user']&& $_SESSION['login_user']!='EnVictO')){
     echo "<div class='Feeds'><span class='whoposted'>
     ".$nme." posted an update on <span style='color:yellow;'>"
     .$date."</span> <span class='glyphicon glyphicon-bullhorn'>
     </span> </span><br><h3>".$post."</h3><br><span style='width:10px;height:10px;' class='glyphicon glyphicon-remove' >
     </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <span style='color:#5cb85c;' id='like' class='glyphicon glyphicon-thumbs-up'>
     </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <span style='color:#c9302c;' id='dislike' class='glyphicon glyphicon-thumbs-down' value='-1'></span></div> <br>";
   }
   #If user is admin a label is shown in the post.
   elseif(($rows[0]==1 && $_SESSION['login_user']=='PSN')|| ($rows[0]==2 && $_SESSION['login_user']=='EnVictO')){
     echo "<div class='Feeds'><span class='whoposted'>
     ".$nme." posted an update on <span style='color:yellow;'>"
     .$date."</span> <span class='glyphicon glyphicon-bullhorn'></span>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     ".$label."
     </span><br><h3>".$post."</h3><br><span style='width:10px;height:10px;' class='glyphicon glyphicon-remove' >
     </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <a href='delete.php/?ID=".$postID."'>
     <span style='color:#5cb85c;' id='like' class='glyphicon glyphicon-thumbs-up' value='1'>
     </span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <span style='color:#c9302c;' id='dislike' class='glyphicon glyphicon-thumbs-down' value='-1'></span></div> <br>";
   }
   elseif($rows[0]==1||$rows[0]==2){
     echo "<div class='Feeds'><span class='whoposted'>
     ".$nme." posted an update on <span style='color:yellow;'>"
     .$date."</span> <span class='glyphicon glyphicon-bullhorn'></span>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     ".$label."
      </span><br><h3>".$post."</h3><br> <a href='delete.php/?ID=".$postID."'>
     <span style='color:#5cb85c;' id='like' class='glyphicon glyphicon-thumbs-up'>
     </span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <span style='color:#c9302c;' id='dislike' class='glyphicon glyphicon-thumbs-down' value='-1'></span></div> <br>";
   }
   else{
    echo "<div class='Feeds'><span class='whoposted'>
    ".$nme." posted an update on <span style='color:yellow;'>"
    .$date."</span> <span class='glyphicon glyphicon-bullhorn'>
    </span> </span><br><h3>".$post."</h3><br> <a href='delete.php/?ID=".$postID."'>
    <span style='color:#5cb85c;' id='like' class='glyphicon glyphicon-thumbs-up'>
    </span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <span style='color:#c9302c;' id='dislike' class='glyphicon glyphicon-thumbs-down' value='-1'></span></div> <br>";
  }
}
}
?>
</div>
</center></main>
</body>
</html>
