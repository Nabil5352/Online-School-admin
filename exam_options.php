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
if(isset($_GET['qid'])){
$qid = $_GET['qid'];
$opsSQL = mysql_query("SELECT * FROM `questions_options` WHERE `ques_id`=$qid");
$cat_list="";

while($row = mysql_fetch_array($opsSQL)) {
$option_id = $row['option_id'];
$options = 	$row['options'];

$cat_list .= "<table class='CategoryContentInside' width='50%' border='0'>	
			<tr>
				<td width='100' align='center'>$option_id</td>
				<td width='100' align='center'>$options</td>
			</tr>				
			</table>";			
	}
}
else {
	header('location:exam_questions.php?ed');
	exit();
}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title> OS | Exam Controller </title>
		<link href="style/css/index.css" rel="stylesheet "/>
		<link href="style/css/category.css" rel="stylesheet "/>		
		<link rel="shortcut icon" href="style/img/favicon.ico">
		<style>
		.CategoryContentInside{
			margin-left: 17%;
		}

		.CategoryBarInside{
			margin-left: 17%;
		}
		</style>
	</head>
	
	<body>
	<?php
		$title = "Exam Controller";
		include "sub_index.php";
	?>

	<div class="control_center_top">
		<div class="control_center_top_inside">
			&nbsp;&nbsp;<span class="control_center_top_text_left"><a href="exam.php">Exam Controller</a></span>&nbsp;&nbsp;&nbsp;&#187;&nbsp;
			<span class="control_center_top_text_right"><a href=""> Questions Options</a></span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="result.php"><img class="control_center_top_ico_result" src="style/img/result.png" title="Result Archive"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit" alt="ico"></a>
			<a href='exam_edit.php?editops&qid=<?php echo $qid; ?>'><img class='control_center_top_ico' src='style/img/edit.png' title='Edit' alt='ico'></a>
			<a href="exam.php"><img class="control_center_top_ico" src="style/img/new.png" title="New Question" alt="ico"></a>
		</div>
	</div>

	<div class="CategoryContent">
		<div class="categoryBar">
			<table class="CategoryBarInside" width="50%" border="0">
			<tr>
				<td class="BarTitle" width="100" align='center'>Option ID</td>
				<td class="BarTitle" width="100" align='center'>Options</td>
			</tr>
			</table>
			<br/>
            <?php echo $cat_list; ?>
		</div>
		
	</div>


	</div>
	<p class="bottomText">&#169;&nbsp;<a href="http://localhost/OnlineSchool/">Online School</a></p>
		
		
	</body>
</html>