<?php
   session_start();
   if(!isset($_SESSION['login_user'])){
      echo "You are not logged in";
	 header("Location: index.php");
   }
?>
