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
    if(isset($_GET['uid'])){
	
	$result_detail = "";
	$user_id = $_GET['uid'];
	$sql = mysql_query("SELECT * FROM `result_archive` WHERE `user_id`= '$user_id'");
	
	while ($rows = mysql_fetch_array($sql)){	
	$exam_id  = $rows['exam_id'];
	$total_marks = $rows['total_marks'];
	$obtained_marks = $rows['obtained_marks'];
	$date  = $rows['date_of_exam'];

	$str_Pattern =  '/[^0-9]*$/';
	preg_match($str_Pattern, $exam_id, $results);

	if($results[0] == 'a'){
	$result_type = "Advanced";
	}
	else if($results[0] == 'b'){
	$result_type = "Beginner";
	}
	else if($results[0] == 'e'){
	$result_type = "Experts";
	}

	$type_id = $exam_id/10;
	$type_sql = mysql_query("SELECT * FROM subcategory WHERE Subcategory_id=$type_id");
	while($row = mysql_fetch_array($type_sql)){
		$result_name = $row['Subcategory_name'];
	}

	$result_detail .= "
		<dl class='dl-horizontal' margin-left:5%;>
        <dt class='row_title'>Exam Name :</dt>
        <dd class='row_val'>$result_name</dd><p>
		<dt class='row_title'>Exam Type :</dt>
        <dd class='row_val'>$result_type</dd><p>		 
        <dt class='row_title'>Exam Date :</dt>
        <dd class='row_val'>$date</dd><p>
		<dt class='row_title'>Total Marks :</dt>
        <dd class='row_val'>$total_marks</dd><p>
		<dt class='row_title'>Obtained Marks :</dt>
        <dd class='row_val'>$obtained_marks</dd><p>
		<dt><a href='result_delete.php?uid=$user_id&xm_id=$exam_id'>Delete Result</a></dt><p>
		<dd></dd><p>
        </dl><hr/>";
	}
}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title> OS | Result Details </title>
		<link href="style/css/new_modify_for_exam.css" rel="stylesheet "/>
		<link href="style/css/index.css" rel="stylesheet "/>
   		<link href="style/css/category.css" rel="stylesheet "/>
   		<link href="style/css/result.css" rel="stylesheet "/>
   		<link rel="shortcut icon" href="style/img/favicon.ico">
    	</head>
	<body>
	<?php
		$title = "Result Details";
		include "sub_index.php";
	?>

	<div class="control_center_top">
		<div class="control_center_top_inside">
			&nbsp;&nbsp;<span class="control_center_top_text_left"><a href="result.php">Result Archives</a></span>&nbsp;&nbsp;&nbsp;&#187;&nbsp;
			<span class="control_center_top_text_right"><a href="">Result Details</a></span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit" alt="ico"></a>
			<a href="result.php"><img class="control_center_top_ico" src="style/img/result.png" title="Main" alt="ico"></a>
		</div>
	</div>

	<div class="CategoryContent">
		<div class="categoryBar">

 			<div class="row-fluid">
  				<div class="span9">
  					<div class="well well-large">
  					<header class='modal-header' >
					<span class='badge badge-info' >Result Board</span>
					</header>

				<div class='modal_body'>		
				<?php
					echo $result_detail;
				?>
				</div>
					</div>
				</div>
			</div>
		</div>
	</div>		

</div>
	<p class="bottomText">&#169;&nbsp;<a href="http://localhost/OnlineSchool/">Online School</a></p>
<script src="../style/js/jquery.js"></script>
<script src="../style/js/jquery-ui.js"></script>
</body>
</html>