<?php
include "xtra/connect.php";

if(isset($_GET['uid']) ){
	$user_id = $_GET['uid'];

	$sql = mysql_query("DELETE FROM `user` WHERE `user_id`='$uid'");

	header("location:user_profile.php");
	exit();
}
	
	else{
	header("location:user_profile.php");
	exit();
}
?>