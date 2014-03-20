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
$userList = "";

$userList .= "<tr class='info'>
			<td width='30%' align='center'>$user</td>
			<td width='30%' align='center'>$time</td>
			<td width='30%' align='center'>$date</td>
		</tr>";
?>

<?php
$articleList = "";

$POSTsql = mysql_query("SELECT * FROM `tuto` ORDER BY `date` LIMIT 4");

	while($row = mysql_fetch_array($POSTsql)){
	$title = $row["Tuto_desc"];
	$date = $row["date"];
	$writer = $row["Writer"];

$articleList .= "<tr class='info'>
			<td width='40%'>$title</td>
			<td width='20%'>$date</td>
			<td width='30%'>$writer</td>
		</tr>";
	}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title> OS | Admin Area </title>
		<link href="style/css/index.css" rel="stylesheet "/>
		<link rel="shortcut icon" href="style/img/favicon.ico">
	</head>
	
	<body>
	<?php
		$title = "Home";
		include "sub_index.php";
	?>

	<div class="control_center">
	<div class="control_center_boxes">
		<div class="AddArticleBox">
			<img class="control_center_ico" src="style/img/article_add.png">
			<br/><a href="article.php">Article Manager</a>
		</div>
		<div class="ArticleManagerBox">
			<img class="control_center_ico" src="style/img/exam.png">
			<br/><a href="exam.php">Exam Controller</a>
		</div>
		<div class="CategoryBox">
			<img class="control_center_ico" src="style/img/category.png">
			<br/><a href="category.php">Category Manager</a>
		</div>
		<div class="VideoManagerBox">
			<img class="control_center_ico" src="style/img/videoManager.png">
			<br/><a href="video.php">Video Manager</a>
		</div>
		<div class="MediaManagerBox">
			<img class="control_center_ico" src="style/img/mediaManager.png">
			<br/><a href="media.php">Media Manager</a>
		</div>
		<div class="UserManagerBox">
			<img class="control_center_ico" src="style/img/UserManager.png">
			<br/><a href="user_profile.php">User Manager</a>
		</div>
		<div class="EditProfileBox">
			<img class="control_center_ico" src="style/img/editProfile.png">
			<br/><a href="profile.php">Edit Profile</a>
		</div>
		<div class="UpdateManagerBox">
			<img class="control_center_ico" src="style/img/updateManager.png">
			<br/><a href="#">Update Manager</a>
		</div>
		<div class="GlobalConfigurationBox">
			<img class="control_center_ico" src="style/img/GlobalConfig.png">
			<br/><a href="#">Global Configuration</a>
		</div>
		<div class="NoteBox">
			<img class="control_center_ico" src="style/img/notes.png">
			<br/>&nbsp;&nbsp;<a href="#">Notes</a>
		</div>
		<div class="MailInbox">
			<img class="control_center_ico" src="style/img/mailInbox.png">
			<br/><a href="#">Mail Inbox</a>
		</div>
	</div>

	<div class="control_center_board">
		<div class="user_info">
			<h4>Last logged in:</h4>
			<table width="80%" border="0">
			<tr class="title">
				<td width='30%' align='center'> Username </td>
				<td width='30%' align='center'> Time </td>
				<td width='30%' align='center'> Date </td>
			</tr>
			<?php
				echo $userList;
			?>
		</table><br/><br/>

		<h4>Top articles:</h4>
			<table width="90%" border="0">
			<tr class="title">
				<td width='30%'> Title </td>
				<td width='30%'> Published </td>
				<td width='30%'> Writer </td>
			</tr>
			<?php
				echo $articleList;
			?>
		</table>
		</div>
	</div>
	</div>

	</div>
	<p class="bottomText">&#169;&nbsp;<a href="http://localhost/OnlineSchool/">Online School</a></p>
		
		
	</body>
</html>