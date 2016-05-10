<?php
include('includes/session.php');
include('includes/mysql_connection.php');
function secure_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}
$msg="";
if(isset($_POST['action'])){
if($_POST['action']=="picupload"){
	//Check if the file is well uploaded
	if($_FILES['file']['error'] > 0) { echo 'Error during uploading, try again'; }
	//We won't use $_FILES['file']['type'] to check the file extension for security purpose
	//Set up valid image extensions
	$extsAllowed = array( 'jpg', 'jpeg', 'png', 'gif' );
	//Extract extention from uploaded file
		//substr return ".jpg"
		//Strrchr return "jpg"
	$extUpload = strtolower( substr( strrchr($_FILES['file']['name'], '.') ,1) ) ;
	//Check if the uploaded file extension is allowed
	if (in_array($extUpload, $extsAllowed) ) {
	//Upload the file on the server
	$name = "img/{$_FILES['file']['name']}";
	$result = move_uploaded_file($_FILES['file']['tmp_name'], $name);
	if($result){echo "<img src='$name'/>";}
	} else { echo 'File is not valid. Please try again'; }
}}
$name=$_SESSION['login_user'];
$sql="select id from mysql.registration_zany where username='".$name."'";
$res=mysqli_query($con,$sql);
$res1=mysqli_fetch_assoc($res);
$id=$res1["id"];
$sql="select count(id) from mysql.friends where id='".$id."' and Request_Status = 0";
$res=mysqli_query($con,$sql);
$row = mysqli_fetch_row($res);
$friends = $row[0];
$msg="select count(senderID) from mysql.messages where receiverID='".$id."' and Visited = 0";
$rmsg=mysqli_query($con,$msg);
$rowmsg = mysqli_fetch_row($rmsg);
$messages = $rowmsg[0];
?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo "Home - ".$_SESSION['login_user']; ?></title>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="../js/active.js"></script>
  <link rel="stylesheet" href="css/welcome_style.css" type="text/css">
</head>
<body>
  <header>
    <div id="navbar">
   <a id="userwel" href=#user><img id="#dp"><?php echo "Hello, ".$_SESSION['login_user']; ?></a>
      <a id="logo" href="welcome.php"><img alt="Brand" id="logobrand" src="/images/logo.png"></img></a>
  <a id="logout" href="/logout.php">Logout</a>

<a id="msg" href="../messages.php"> <button class="btn btn-danger" type="button">
Messages <span class="badge"><?php echo $messages; ?></span>
</button></a>
<a id="msg" href="../friends.php?Req=True"> <button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-user"></span>
Friends&nbsp;<span class="badge"><?php echo $friends; ?></span>
</button></a>
 </div>
 </header>

 <div id="Profile_Head">
   <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" >
   <input type="file" name ="file">
   <input name="action" type="hidden" value="picupload" >
   		<input type="submit" value = "Upload"></form></div>
 <div id="sidebar">
   <ul>
     <li>
      <a href="../welcome.php" class=<?php echo ($_SERVER['PHP_SELF'] == "/welcome.php" ? "active" : "na");?>><span class="glyphicon glyphicon-home"> Home</span></a>
     </li>
     <li>
    <a href="../friends.php" class=<?php echo ($_SERVER['PHP_SELF'] == "/friends.php" ? "active" : "na");?> ><span class="glyphicon glyphicon-user"> Friends</span></a>
     </li>
     <li>
      <a href="#" class=<?php echo ($_SERVER['PHP_SELF'] == "/messages.php" ? "active" : "na");?>> <span class="glyphicon glyphicon-envelope"> Messages</span></a>
     </li>
     <li>
      <a href="../search.php" class=<?php echo ($_SERVER['PHP_SELF'] == "/search.php" ? "active" : "na");?>><span class="glyphicon glyphicon-home"> FindFriends</span></a>
     </li>
     <li>
      <a href="../profile.php" class=<?php echo ($_SERVER['PHP_SELF'] == "/profile.php" ? "active" : "na");?>><span class="glyphicon glyphicon-credit-card"> Settings</span></a>
     </li>
   </ul>

 </div>

</body>
</html>
