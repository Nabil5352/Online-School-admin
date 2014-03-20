<?php
session_start();

if(isset($_POST["username"])&& isset($_POST["password"])){
	
$admin = preg_replace('#[^0-9A-Za-z]#i','',$_POST["username"]);
$password = preg_replace('#[^0-9A-Za-z]#i','',$_POST["password"]);

include "xtra/connect.php";

$sql = mysql_query("SELECT * FROM admin WHERE username= '".$admin."' AND password= '".$password."' LIMIT 1");

$row = mysql_num_rows($sql);
if($row>0){
	while($f_row = mysql_fetch_array($sql)){
		$id = $f_row["id"];
		}
		$_SESSION["id"]=$id;
		$_SESSION["admin"]=$admin;
		$_SESSION["password"]=$password;
		mysql_query("UPDATE `admin` SET `last_log_date`=now() WHERE `id`=$id");
		mysql_query("UPDATE `admin` SET `time`=now() WHERE `id`=$id");
		header("location: index.php");
		exit;
	}
else{
	header("location:enter_admin.php");
	exit;
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Online School | Admin Log In</title>
	<link href="style/css/index.css" rel="stylesheet">
	<link rel="shortcut icon" href="style/img/favicon.ico">		
</head>

<body style="background-color:#fbf9f9;">
	<div class="container">
		<div class="firstBar">
			<div class="firstBarText"> Admin Area </div>
		</div>
		<div class="secondBar"></div>
			
		<div class="contentWrapper">
		<div class="WrapperText">
			<p class="WrapperTitle">Online School - Administration!</p>
			<p class="WrapperDesc">***Use a valid username and password to gain access to the administrator backend.
				<br/><br/><a href="http://localhost/OnlineSchool/">Go to site home page.</a>
			</p>
		</div>
		<div class ="content">
				<form id="log_in_form" name="log_in_form" method="post" action="enter_admin.php">
                Username: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="username" type="text" id="username" maxlength="15"><br/><br/>
                Password: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="password" type="password" id="password" maxlength="15"><br/><br/><br/>

                <input type="submit" name="button" id="button" value="Log In">

                </form>
          </div>
          </div>
	</div>
	<p class="bottomText"><a href="http://localhost/OnlineSchool/">Online School</a> is a free learning site.</p>
</body>

</html>