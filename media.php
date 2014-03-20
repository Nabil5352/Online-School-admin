<?php
session_start();

if(!isset($_SESSION["admin"])){
	header("location:enter_admin.php");
	exit("");
}

include "xtra/connect.php";
//checking session value in database

$admin = preg_replace('#[^0-9A-Za-z]#i','',$_SESSION["admin"]);
$password = preg_replace('#[^0-9A-Za-z]#i','',$_SESSION["password"]);

$sql = mysql_query("SELECT * FROM admin WHERE username= '".$admin."' AND password= '".$password."'");

if(!mysql_num_rows($sql) >= 1)
    {
    die();
	}
	
while($row = mysql_fetch_array($sql)) {
    $id = $row['id'];
    $user = $row['username'];
	$pass = $row['password'];
	$date = $row["last_log_date"];
	$time = $row["time"];	
	}   
	
if(!strcmp($user,$admin)==0 && !strcmp($pass,$password)==0)
	{
		header("location:enter_admin.php");
		exit;
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title> OS | Media Manager </title>
 		
 		<link href="style/css/new_modify_for_exam.css" rel="stylesheet"/>  
   		<link href="style/css/index.css" rel="stylesheet"/>
   		<link href="style/css/category.css" rel="stylesheet"/>
   		<link href="style/css/media.css" rel="stylesheet"/>
		<link rel="shortcut icon" href="style/img/favicon.ico">
		</head>
<body>
<?php
		$title = "Media Manager";
		include "sub_index.php";
?>

	<div class="control_center_top">
		<div class="control_center_top_inside">
			&nbsp;&nbsp;<span class="control_center_top_text_left"><a href="">Media Manager</a></span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit"></a>
		</div>
	</div>

<div class="CategoryContent">
<div class="categoryBar">		   
	<div class='imgBar'>
		<img class="upIco" src="style/img/img_upload.png" title="img_upload" alt="ico">
		<form action='media_upload.php?img' enctype="multipart/form-data" method='POST'>
			<lable class='up_txt' name='up_txt'>Upload Image:</label><br/>
			<select class='destination' name='destination' id='destination'>
				<option disabled='disabled'>Destination</option>
				<option value='adminPic'>Admin Panel (PNG)</option>
				<option value='sitePic'>Site Panel (JPG, PNG)</option>
				<option value='profilePic'>User Profile Pic (JPG)</option>
			</select>
			<label class='up_btn'><input name="fileField" type="file"/></label>
			<input class='btn btn-info' type='submit' name='submit' value='Upload!'>
		</form>
	</div>
	<div class='vidBar'>
		<img class="upIco" src="style/img/vid_upload.png" title="vid_upload" alt="ico">
		<form action='media_upload.php?vid' enctype="multipart/form-data" method='POST'>
			<lable class='up_txt' name='up_txt'>Upload Video:</label><br/>
				<select class='destination' name='destination' id='destination'>
				<option disabled='disabled'>Destination</option>
				<option value='vid'>Video tutorial (OGG)</option>
			</select>
			<label class='up_btn'><input name="fileField" type="file"/></label>
			<input class='btn btn-info' type='submit' name='submit' value='Upload!'>
		</form>
	</div>
</div>			
</div>

</div>
	<p class="bottomText">&#169;&nbsp;<a href="http://localhost/OnlineSchool/">Online School</a></p>
<script src="../style/js/jquery.js"></script>
<script src="../style/js/jquery-ui.js"></script>
<script src="../style/js/exam.js"></script>
</body>
</html>