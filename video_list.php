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
if(isset($_GET['sid'])){
	$sid = $_GET['sid'];
	$vidSQL = mysql_query("SELECT * FROM `video_links` WHERE `Subcategory_id`=$sid  ORDER BY `Subcategory_id`");
	$vid_list="";

	while($row = mysql_fetch_array($vidSQL)) {
		$sbID = $row['Subcategory_id'];
		$lstID = $row['List_id'];
		$lstTitle = $row['List_title'];
		$desc = $row['desc'];
		$views = $row['views'];

	$vid_list .= "<table class='CategoryContentInside' width='90%' border='0'>	
			<tr>
				<td width='100' align='center'>$lstID</td>
				<td width='100'>$lstTitle</td>
				<td width='100' align='center'>$desc</td>
				<td width='100' align='center'>$views</td>
				<td width='100' align='center'>
				<a href='editVid.php?lstid=$lstID'><img class='action_ico' src='style/img/edit.png' title='Edit' alt='ico'>
				</a> &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp; 
				<a href='deleteVid.php?lstid=$lstID'><img class='action_ico' src='style/img/delete.png' title='Delete' alt='ico'></a> 
				</td>
			</tr>				
			</table>";			
	}
}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title> OS | Video List </title>
		<link href="style/css/index.css" rel="stylesheet "/>
		<link href="style/css/category.css" rel="stylesheet "/>		
		<link rel="shortcut icon" href="style/img/favicon.ico">
	</head>
	
	<body>
	<?php
		$title = "Video List";
		include "sub_index.php";
	?>

	<div class="control_center_top">
		<div class="control_center_top_inside">
			&nbsp;&nbsp;<span class="control_center_top_text_left"><a href="video.php">Video Manager</a></span>&nbsp;&nbsp;&nbsp;&#187;&nbsp;
			<span class="control_center_top_text_right"><a href="">Video List</a></span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit" alt="ico"></a>
		</div>
	</div>

	<div class="CategoryContent">
		<div class="categoryBar">
			<table class="CategoryBarInside" width="90%" border="0">
			<tr>
				<td class="BarTitle" width="100" align='center'>ID</td>
				<td class="BarTitle" width="100">Title name</td>
				<td class="BarTitle" width="100" align='center'>Description</td>
				<td class="BarTitle" width="100" align='center'>Hit</td>
				<td class="BarTitle" width="100" align='center'>Action</td>
			</tr>
			</table>
			<br/>
            <?php echo $vid_list; ?>
		</div>
		
	</div>


	</div>
	<p class="bottomText">&#169;&nbsp;<a href="http://localhost/OnlineSchool/">Online School</a></p>
		
		
	</body>
</html>