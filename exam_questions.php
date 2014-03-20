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
$xmSQL = mysql_query("SELECT * FROM `questions` ORDER BY `ques_id`");
$cat_list="";

while($row = mysql_fetch_array($xmSQL)) {
$xmID = $row['exam_id'];
$quesID = $row['ques_id'];
$quesTitle = $row['ques_title'];
$ans = 	$row['answer'];

$topic_id = $xmID/10;
$topic_sql = mysql_query("SELECT * FROM subcategory WHERE Subcategory_id=$topic_id");
while($row = mysql_fetch_array($topic_sql)){
		$topic = $row['Subcategory_name'];
}

$str_Pattern =  '/[^0-9]*$/';
preg_match($str_Pattern, $xmID, $results);

if($results[0] == 'a'){
	$val = "Advanced";
}
else if($results[0] == 'b'){
	$val = "Beginner";
}
else if($results[0] == 'e'){
	$val = "Experts";
}

if(isset($_GET['ed'])){
	$type = "Edit ";
	$del="";
	$edit="<a href='exam_edit.php?editques&qid=$quesID'><img class='action_ico' src='style/img/edit.png' title='Edit' alt='ico'></a>";
}
else if(isset($_GET['del'])){
	$type = "Delete ";
	$del="<a href='exam_delete.php?all&qid=$quesID'><img class='action_ico' src='style/img/delete.png' title='Delete' alt='ico'></a>";
	$edit="";
}
else{
	header('location:exam.php');
	exit();
}

$cat_list .= "<table class='CategoryContentInside' width='90%' border='0'>	
			<tr>
				<td width='100' align='center'>$topic</td>
				<td width='100' align='center'>$val</td>
				<td width='100' align='center'>$quesID</td>
				<td class='BarContent' width='200'><a href='exam_options.php?qid=$quesID'>$quesTitle</a></td>
				<td width='100' align='center'>$ans</td>
				<td width='100' align='center'>
				$edit
				$del
				</td>
			</tr>				
			</table>";			
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
	</head>
	
	<body>
	<?php
		$title = "Exam Controller";
		include "sub_index.php";
	?>

	<div class="control_center_top">
		<div class="control_center_top_inside">
			&nbsp;&nbsp;<span class="control_center_top_text_left"><a href="exam.php">Exam Controller</a></span>&nbsp;&nbsp;&nbsp;&#187;&nbsp;
			<span class="control_center_top_text_right"><a href=""><?php echo $type; ?> Questions</a></span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="result.php"><img class="control_center_top_ico_result" src="style/img/result.png" title="Result Archive"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit" alt="ico"></a>
			<a href="exam.php"><img class="control_center_top_ico" src="style/img/new.png" title="New Question" alt="ico"></a>
		</div>
	</div>

	<div class="CategoryContent">
		<div class="categoryBar">
			<table class="CategoryBarInside" width="90%" border="0">
			<tr>
				<td class="BarTitle" width="100" align='center'>Topic</td>
				<td class="BarTitle" width="100" align='center'>Difficulty</td>
				<td class="BarTitle" width="100" align='center'>Question ID</td>
				<td class="BarTitle" width="200">Question Title</td>
				<td class="BarTitle" width="100" align='center'>Answer</td>
				<td class="BarTitle" width="100" align='center'>Action</td>
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