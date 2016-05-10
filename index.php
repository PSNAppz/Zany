﻿<?php ob_start();
session_start();
include('includes/mysql_connection.php');
       error_reporting(E_ALL|E_STRICT);
         ini_set('display_errors',true);
          $msg = '';
          $msg1= '';
          if(isset($_POST['action'])){
          if($_POST['action']=="login"){
               $user=secure_input($_POST['username']);
               $pass=secure_input($_POST['password']);
               if(!empty($user) && !empty($pass)){
                $sql="SELECT password from mysql.registration_zany where username ='".$user."'";
                $res=mysqli_query($con,$sql);
                if(mysqli_num_rows($res)>0){
                  $row=mysqli_fetch_assoc($res);
                  if($row["password"]==$pass){
                   $_SESSION['login_user']=$user;
                   $msg= $_SESSION['login_user'];
                   header("Location: welcome.php");
                   exit();
                 }
                 else{
                  $msg = '<div class="alert alert-danger">
         <strong>Error!</strong> Wrong username or Password.
       </div>';
     }
              }
              else{
               $msg = '<div class="alert alert-danger">
      <strong>Error!</strong> Wrong username or Password.
    </div>';
              }
             }
             else{
                $msg = '<div class="alert alert-danger">
       <strong>Error!</strong> Please enter all fields!
     </div>';
               }
       }
       elseif($_POST['action']=="register"){
         $user=secure_input($_POST['uname']);
         $fname=secure_input($_POST['fname']);
	 $pass1=secure_input($_POST['pass1']);
         $pass=secure_input($_POST['rpassword']);
         $email=secure_input($_POST['remail']);
         $sql="select count(*) from mysql.registration_zany where username='".$user."'";
         $res=mysqli_query($con,$sql);
         $row = mysqli_fetch_row($res);
         $user_count = $row[0];
         if(!empty($user) && !empty($pass) && $user_count==0){
$sql="INSERT INTO mysql.registration_zany (username, name, email, password) VALUES ('".$user."', '".$fname."', '".$email."', '".$pass."')";
	    $test=mysqli_query($con,$sql);
      $sql="select id from mysql.registration_zany where username='".$user."'";
      $res=mysqli_query($con,$sql);
      $res1=mysqli_fetch_assoc($res);
      $id=$res1["id"];
      $sql="insert into mysql.friends (id2, id, Request_Status) values('".$id."','".$id."','1')";
      mysqli_query($con,$sql);
           $msg1="<div class='alert alert-success'>
Succesfully Registered!</div>";

         }

         elseif($user_count>0){
           $msg1='<div class="alert alert-warning">
  <strong>Error!</strong> UserName already exists!
</div>';
         }
         else{
           $msg1='<div class="alert alert-danger">
  <strong>Error!</strong> Please enter all fields!
</div>';
                  }
       }

     }
     function secure_input($data) {
 $data = trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
 return $data;
}
ob_flush(); ?>

<!DOCTYPE HTML>
<html>
<head><title>ZanY&trade; Welcome</title>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/style.css" type="text/css"></head>
<script>
function checkAvailability() {
	$("#loaderIcon").show();
	jQuery.ajax({
	url: "check_availability.php",
	data:'username='+$("#username").val(),
	type: "POST",
	success:function(data){
		$("#user-availability-status").html(data);
		$("#loaderIcon").hide();
	},
	error:function (){}
	});
}
</script>
<body>
  <header>
  <h1 id="loginhead">ZaNy<span style="font-size:20px;">&trade;</span></h1>
</header>
<br>
<br><br>
<br>
<center>
  <div class="jumbotron" id="jumbro">
  <h1>Welcome to Zany&trade; Networks<span style="font-size:10px;" class="label label-warning">Beta V1.0</span>
</h1>
  <p>Please Login or Register</p>
  <p><button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-lg">Login</button>
<button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-lg1">Register</button>
<?php echo $msg; ?>
<?php echo $msg1; ?>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
  <div class="container">
  <h2>Login to ZanY</h2>
  <form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
    <div class="form-group">
      <label for="usr">Username:</label>
      <input type="text" name="username" class="form-control" id="usr">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" name="password" class="form-control" id="pwd">
       <input name="action" type="hidden" value="login" >
      <input type="submit" name="login-btn" value="Login">
   <?php echo $msg; ?>
   </div>
</form>
</div>
</div>
</div>
</div>
<div class="modal fade bs-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="container">
        <h2 style="text-align:center;">Registration form</h2>
        <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" >
          <div class="form-group">
            <label class="control-label col-sm-2" for="fn">User  Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="uname" id="username" placeholder="Enter UserName" onBlur="checkAvailability()">
            </div>
            <span id="user-availability-status"></span>
            <p><img  src="images/LoaderIcon.gif" id="loaderIcon" style="width:40px; height:40px; display:none; " /></p>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="fname">Full Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="fname" id="fname" placeholder="Enter Full Name">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="email">Email:</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" name="remail" id="email" placeholder="Enter email">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Password:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="rpassword" id="pwd" placeholder="Enter password">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2" for="cp">Confirm Password:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="pass1" id="cp" placeholder="Confirm password">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
               <input name="action" type="hidden" value="register" >

            </div>
            <input type="submit" name="registration-btn" value="Register" class="btn btn-default">

          </div>
          <?php echo $msg1; ?>
        </form>
      </div>
</form>
</div>
</div>
</div>
</div>
</center>
<center>
<div class="github-card" data-github="PSNAppZ" data-width="400" data-height="" data-theme="default"></div>
<script src="//cdn.jsdelivr.net/github-cards/latest/widget.js"></script>
</center>
  <footer>
    <p>Copyright&copy; 2016 ZanY&trade; Networks inc. All rights Reserved.&nbsp;&nbsp;&nbsp;<em>Hand-made with ❤.</em></p>
  </footer>
</body>
</html>
