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
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
if(isset($_POST['action'])){
if($_POST['action']=="picupload"){

	// Check if image file is a actual image or fake image
	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	    if($check !== false) {
	        echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}
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
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="../js/active.js"></script>
<script src="../js/script.js"></script>
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
   <input type="file" name="fileToUpload" id="fileToUpload">
   <input name="action" type="hidden" value="picupload" >
   		<input type="submit" value = "Upload"></form></div>
	 <body>

<!-------------------- CHAT BOX ----------------------->



     <div class='chat-sidebar'>
		 <center><p style="color:white;"><b>Friends Online <span style="color:red;" class="glyphicon glyphicon-user"></span></b></p></center>
		 <?php
		 $sqlfrnd="select id from mysql.friends where id2='".$id."' and Request_Status=1";
		 $resfr=mysqli_query($con,$sqlfrnd);
		 $cnt=0;
		 while($res1=mysqli_fetch_array($resfr,MYSQLI_NUM)){
		 $id2=$res1[0];
		 $sqlfrd="select username,Online from mysql.registration_zany where id='".$id2."'";
		 $res1=mysqli_query($con,$sqlfrd);
		 $row=mysqli_fetch_assoc($res1);
		 if($row["Online"]!=0){
			 $cnt=1;
		   if($row["username"]!=$_SESSION['login_user']){
				 echo"<div class='sidebar-name'>
									 <a href=\"javascript:register_popup('".$row["username"]."', '".$row["username"]."');\">
											 <span class=' glyphicon glyphicon-globe' style='color:green;'></span>
											 <span>".$row["username"]."</span>
									 </a>
							 </div>";
		 }}}
		 if($cnt==0){
			 echo $row["Online"];
			 echo "<div class='sidebar-name'>0 users online!</div>";
		 }
				 ?>
			 </div>
				 <!--------------------------  CHAT BOX END ---------------------->
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
