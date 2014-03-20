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
<?php
$xmneeSQL = mysql_query("SELECT DISTINCT `user_id` FROM `result_archive` ORDER BY `date_of_exam` ASC");
$xmnee_list="";

while($row = mysql_fetch_array($xmneeSQL)) {
$user_id = $row['user_id'];

$usrSQL = mysql_query("SELECT *  FROM `user` WHERE `user_id`='$user_id'");
while($row = mysql_fetch_array($usrSQL)) {
	$user_name = $row['user_name'];
}

$countSQL = mysql_query("SELECT * FROM `result_archive` WHERE `user_id`='$user_id'");
$count = mysql_num_rows($countSQL);

$xmnee_list .= "<table class='CategoryContentInside' width='50%' border='0'>	
			<tr>
				<td width='100' align='center'>$user_name</td>
				<td width='100' align='center'>$count times</td>
				<td width='100' align='center'><a href='result_view_details.php?uid=$user_id'>View Details</a></td>
			</tr>				
			</table>";			
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title> OS | Result Archive </title>
 
   		<link href="style/css/index.css" rel="stylesheet "/>
   		<link href="style/css/category.css" rel="stylesheet "/>
   		<link href="style/css/result.css" rel="stylesheet "/>
		<link rel="shortcut icon" href="style/img/favicon.ico">
		</head>
<body>
<?php
		$title = "Result Archive";
		include "sub_index.php";
?>

	<div class="control_center_top">
		<div class="control_center_top_inside">
			&nbsp;&nbsp;<span class="control_center_top_text_left"><a href="">Result Archive</a></span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit" alt="ico"></a>
			<a href=""><img class="control_center_top_ico" src="style/img/result.png" title="Main" alt="ico"></a>
		</div>
	</div>

<div class="CategoryContent">
<div class="categoryBar">
	<table class="CategoryBarInside" width="50%" border="0">
		<tr>
			<td class="BarTitle" width="100" align='center'>Examenee Name</td>
			<td class="BarTitle" width="100" align='center'>Participants in exam</td>
			<td class="BarTitle" width="100" align='center'>Action</td>
		</tr>
	</table>
<br/>
    <?php echo $xmnee_list; ?>
</div>			
</div>

</div>
	<p class="bottomText">&#169;&nbsp;<a href="http://localhost/OnlineSchool/">Online School</a></p>
<script src="../style/js/jquery.js"></script>
<script src="../style/js/jquery-ui.js"></script>
<script src="../style/js/exam.js"></script>
</body>
</html>