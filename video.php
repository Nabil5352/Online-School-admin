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
$vdSQL = mysql_query("SELECT DISTINCT `Subcategory_id` FROM `video_links` ORDER BY `Subcategory_id`");
$vid_cat_list="";
$count = "";

while($row = mysql_fetch_array($vdSQL)) {
$sbID = $row['Subcategory_id'];

$countSQL = mysql_query("SELECT count(List_id) FROM `video_links` WHERE `Subcategory_id`=$sbID");
$count = mysql_result($countSQL,0);

$sb_sql = mysql_query("SELECT * FROM `subcategory` WHERE `Subcategory_id`=$sbID");
while($row = mysql_fetch_array($sb_sql)){
		$sb_name = $row['Subcategory_name'];
}

$vid_cat_list .= "<table class='CategoryContentInside' width='90%' border='0'>	
			<tr>
				<td width='100' align='center'>$sb_name</td>
				<td width='100' align='center'>$count</td>
				<td width='100' align='center'>	
					<a href='video_list.php?sid=$sbID'> View Details </a>		
				</td>
			</tr>				
			</table>";	
$count="";		
}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title> OS | Video Manager </title>
		<link href="style/css/index.css" rel="stylesheet "/>
		<link href="style/css/category.css" rel="stylesheet "/>		
		<link rel="shortcut icon" href="style/img/favicon.ico">
	</head>
	
	<body>
	<?php
		$title = "Video Manager";
		include "sub_index.php";
	?>

	<div class="control_center_top">
		<div class="control_center_top_inside">
			&nbsp;&nbsp;<span class="control_center_top_text_left"><a href="">Video Manager</a></span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit" alt="ico"></a>
		</div>
	</div>

	<div class="CategoryContent">
		<div class="categoryBar">
			<table class="CategoryBarInside" width="90%" border="0">
			<tr>
				<td class="BarTitle" width="100" align='center'>Topic</td>
				<td class="BarTitle" width="100" align='center'>Number of video</td>
				<td class="BarTitle" width="100" align='center'>Action</td>
			</tr>
			</table>
			<br/>
            <?php echo $vid_cat_list; ?>
		</div>
		
	</div>


	</div>
	<p class="bottomText">&#169;&nbsp;<a href="http://localhost/OnlineSchool/">Online School</a></p>
		
		
	</body>
</html>