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
$formUp = "<!--";
$formDown = "-->";
$selectMenu = "";
$query = mysql_query("SELECT * FROM `subcategory`");

while($row = mysql_fetch_array($query)){
	$subCtgry = $row['Subcategory_name'];
	$subCtgry_id = $row['Subcategory_id'];
	$subCtgry_id = $subCtgry_id*10;

	$selectMenu .= "<option value='$subCtgry_id'>$subCtgry</option>";
}

$selectLevel = "<option value='b'>Beginner</option>
				<option value='a'>Advanced</option>
				<option value='e'>Experts</option>";

$nextButton = "<input type='submit' class='btn btn-primary' id='sign_up' value='Next'>";
?>
<?php
if(isset($_POST['exam_name']) && isset($_POST['exam_type'])){
	$exam_name =  $_POST['exam_name'];
	$exam_type =  $_POST['exam_type'];

	$q_data = $exam_name/10;
	$querySql = mysql_query("SELECT * FROM subcategory WHERE Subcategory_id=$q_data");
	while($row = mysql_fetch_array($querySql)){
		$exam_cat_name = $row['Subcategory_name'];
	}

	if($exam_type = 'a'){
		$val = "Advanced";
	}
	else if($exam_type = 'b'){
		$val = "Beginner";
	}
	else if($exam_type = 'e'){
		$val = "Experts";
	}

	$selectMenu = "<option>$exam_cat_name</option>";
	$selectLevel = "<option>$val</option>";
	$nextButton = "";

	$exam_id = $exam_name.$exam_type;
	$sql = mysql_query("INSERT INTO `questions`(`exam_id`) VALUES ('$exam_id')");

	if(!$sql){
		die(mysql_error());
	}

	$sql2 = mysql_query("SELECT * FROM `questions` WHERE `exam_id`='$exam_id'");
	while($row = mysql_fetch_array($sql2)){
		$ques_id = $row['ques_id'];
	}

	$formUp = "";
	$formDown = "";
}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title> OS | Exam Controller </title>
 
		<link href="style/css/new_modify_for_exam.css" rel="stylesheet"/>  
   		<link href="style/css/index.css" rel="stylesheet "/>
   		<link href="style/css/exam.css" rel="stylesheet "/>
		<link rel="shortcut icon" href="style/img/favicon.ico">
		</head>
<body>
<?php
		$title = "Exam Controller";
		include "sub_index.php";
?>

	<div class="control_center_top">
		<div class="control_center_top_inside">
			&nbsp;&nbsp;<span class="control_center_top_text_left"><a href="exam.php">Exam Controller</a></span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="result.php"><img class="control_center_top_ico_result" src="style/img/result.png" title="Result Archive"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit"></a>
			<a href='exam_questions.php?del'><img class='control_center_top_ico' src='style/img/delete.png' title='Delete' alt='ico'></a>
			<a href='exam_questions.php?ed'><img class='control_center_top_ico' src='style/img/edit.png' title='Edit' alt='ico'>
			<a href=""><img class="control_center_top_ico" src="style/img/new.png" title="New" alt="ico"></a>
		</div>
	</div>

<div class="CategoryContent">
<div class="categoryBar">		   
	
	<div  class="page_header">Add Questions</div>

	<form class="form-horizontal" action="exam.php" method="POST" enctype="multipart/form-data">
        
        <div class="control_group">
			<label class="control-label" for="inputPassword" >Choose Topic :</label>
    	<div class="controls">
			<select name="exam_name" class="country" >
				<option disabled="disabled">Choose a Topic</option>
				<?php echo $selectMenu; ?>
			</select>
			
			<span class="help_inline" id="country"></span>
    	</div>
  		</div>
		
		<div class="control_group">
			<label class="control-label" for="inputPassword" > Choose Level :</label>
    	<div class="controls">
			<select name="exam_type" class="country" >
				<option disabled="disabled" >Choose a Level</option>
				<?php echo $selectLevel; ?>
			</select>
			
			<span class="help_inline" id="country"></span>
    	</div>
  		</div>
		
		<div class="control_group">
    	<div class="controls">
			<?php echo $nextButton; ?>
		</div>
  		</div>
	</form>
	<?php 
	echo $formUp;
	?>	

<form class="insertForm" action="exam_insert_add_question.php" method="POST" enctype="multipart/form-data">
	<table width="75%" border="0" cellspacing="0" cellpadding="0">
	   	<tr>
        	<td width="20%">Question Title:</td>
            <td width="80%"><label><input class='input_xlarge' type='text' id='ques_title' name='ques_title'></label></td>
        </tr>
		<tr>
        	<td width="20%">Options No 1:</td>
            <td width="80%"><label><input class='input_xlarge' type='text' id='options1' name='options1'></label></td>
        </tr>
		<tr>
        	<td width="20%">Options No 2:</td>
           <td width="80%"><label><input class='input_xlarge' type='text' id='options2' name='options2'></label></td>
        </tr>
        <tr>
        	<td width="20%">Options No 3:</td>
            <td width="80%"><label><input class='input_xlarge' type='text' id='options3' name='options3'></label></td>
        </tr>
        </tr>
        <tr>
        	<td width="20%">Options No 4:</td>
            <td width="80%"><label><input class='input_xlarge' type='text' id='options4' name='options4'></label></td>
        </tr>
        </tr>
        <tr>
        	<td width="20%">Answer:</td>
            <td width="80%">
            <label>
            	<select class='answer' name='answer' id='answer' >
					<option disabled='disabled'>Choose Options:</option>
					<option value='op-<?php echo $ques_id; ?>.1'>option 1</option>
					<option value='op-<?php echo $ques_id; ?>.2'>option 2</option>
					<option value='op-<?php echo $ques_id; ?>.3'>option 3</option>
					<option value='op-<?php echo $ques_id; ?>.4'>option 4</option>
				</select>
			</label>
			</td>
        </tr>	
        <input type='hidden' id='exam_id' name='exam_id' value='<?php echo $exam_id; ?>'>
		<input type='hidden' id='ques_id' name='ques_id' value='<?php echo $ques_id; ?>'>
		<input type='hidden' id='option_id1' name='option_id1' value='op-<?php echo $ques_id; ?>.1'>		   
		<input type='hidden' id='option_id2' name='option_id2' value='op-<?php echo $ques_id; ?>.2'>
		<input type='hidden' id='option_id3' name='option_id3' value='op-<?php echo $ques_id; ?>.3'>
		<input type='hidden' id='option_id4' name='option_id4' value='op-<?php echo $ques_id; ?>.4'>
        <tr>
        	<td width="20%">&nbsp;</td>
            <td width="80%"><label><input type='submit' class='btn btn-success' id='submit' value='INSERT'></label></td>
        </tr>       
    </table>
</form>


<?php
	echo $formDown;
?>
</div>			
</div>

</div>
	<p class="bottomText">&#169;&nbsp;<a href="http://localhost/OnlineSchool/">Online School</a></p>
<script src="../style/js/jquery.js"></script>
<script src="../style/js/jquery-ui.js"></script>
<script src="../style/js/exam.js"></script>
</body>
</html>