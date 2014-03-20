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
if(isset($_GET['editques'])){
	if(isset($_GET['qid'])){
		$title = "Edit Questions";
				$qid = $_GET['qid'];

				$query = mysql_query("SELECT * FROM `subcategory` ORDER BY Category_id");
				$selectMenu = "";
				
				while($row = mysql_fetch_array($query)){
				$subCtgry = $row['Subcategory_name'];
				$subCtgry_id = $row['Subcategory_id'];
				$subCtgry_id = $subCtgry_id*10;

				$selectMenu .= "<option value='$subCtgry_id'>$subCtgry</option>";
				}

				$OPTquery = mysql_query("SELECT * FROM `questions_options` WHERE `ques_id`='$qid'");
				$optionMenu = "";

				while($row = mysql_fetch_array($OPTquery)){
				$opt1 = $row['options'];
				$opts = $row['option_id'];

				$optionMenu .= "<option value='$opts'>$opt1</option>";
				}

				
				//Get data from database
				$sql=mysql_query("SELECT * FROM `questions` WHERE `ques_id`='$qid' LIMIT 1");
				$itemCount = mysql_num_rows($sql);

				if($itemCount > 0){
				
				while($row = mysql_fetch_array($sql)){				
				$xmID = $row['exam_id'];
				$quesTitle = $row['ques_title'];
				$ans = $row['answer'];
				}

				$ansSQL = mysql_query("SELECT * FROM `questions_options` WHERE `option_id`='$ans'");
				while($row = mysql_fetch_array($ansSQL)){				
				$ansOps = $row['options'];
				}				

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

				
				$oidInfo = "";				
				$qidInfo = 
				"<tr>
				<td width='20%'>Exam Topic:</td>
				<td width='80%'><label>
				<select class='exam_name' name='exam_name' id='exam_name'>
				<option disabled='disabled'>Choose a Topic</option>
				$selectMenu
				</select>
				</label><span class='selectedVal'>Selected Topic:<span class='slctdVl'>$topic</span></span></td>
				</tr>
				<tr>
				<td width='20%'>Difficulty:</td>
				<td width='80%'><label>
				<select class='exam_type' name='exam_type' id='exam_type' >
					<option disabled='disabled'>Choose Options:</option>
					<option value='b'>Beginner</option>
					<option value='a'>Advanced</option>
					<option value='e'>Experts</option>
				</select>
				</label><span class='selectedVal'>Selected Level:<span class='slctdVl'>$val</span></span></td>
				</tr>
				<tr>
				<tr>
				<td width='20%'>Question_title:</td>
				<td> <input name='ques_title' type='text' id='ques_title' value='$quesTitle' size='25'></td>
				</tr>
				<tr>
				<td width='20%'>Answer:</td>
				<td width='80%'><label>
				<select class='answer' name='answer' id='answer' >
					<option disabled='disabled'>Choose Options:</option>
					$optionMenu
				</select>
				</label><span class='selectedVal'>Selected Answer:<span class='slctdVl'>$ansOps</span></span></td>
				</tr>";
			}
	}
}
else if(isset($_GET['editops'])){
	if(isset($_GET['qid'])){
		$title = "Edit Questions Options";
				$qid = $_GET['qid'];
				
				$oidInfo = "";
				$qidInfo = "";
				$inc = 1;

				$opsSQL = mysql_query("SELECT * FROM `questions_options` WHERE `ques_id`=$qid");

				while($row = mysql_fetch_array($opsSQL)){
				$value = $row['options'];
				$opsID = $row['option_id'];

				$oidInfo .= 
				"<tr>
				<td width='20%'>Option $inc:</td>
				<td> <input name='$inc' type='text' id='$opsID' value='$value' size='25'></td>
				</tr>";

				$inc = $inc+1;
				}			
				
			}
	}


//update
if(isset($_POST['exam_name']) || isset($_POST['exam_type']) || isset($_POST['ques_title']) || isset($_POST['answer'])){
			$exam_name = mysql_real_escape_string($_POST['exam_name']);
			$exam_type = mysql_real_escape_string($_POST['exam_type']);
			$ques_title = mysql_real_escape_string($_POST['ques_title']);
			$answer = mysql_real_escape_string($_POST['answer']);

			$id = $_POST['thisID'];

			$exam_id = $exam_name.$exam_type;
			$sql = mysql_query("UPDATE `questions` SET `exam_id`='$exam_id',`ques_title`='$ques_title',`answer`='$answer' WHERE `ques_id`=$id");
			
			if($sql){
			header('location:exam_questions.php?ed');
			exit();
			}
			else{
			die('Sorry problem happens. Check your settings');
			}
			
}
else if(isset($_POST['1']) || isset($_POST['2']) || isset($_POST['3']) || isset($_POST['4'])){
			$ops_1 = mysql_real_escape_string($_POST['1']);
			$ops_2 = mysql_real_escape_string($_POST['2']);
			$ops_3 = mysql_real_escape_string($_POST['3']);
			$ops_4 = mysql_real_escape_string($_POST['4']);

			$id = $_POST['thisID'];

			mysql_query("UPDATE `questions_options` SET `options`='$ops_1' WHERE `option_id`='op-$id.1'");
			mysql_query("UPDATE `questions_options` SET `options`='$ops_2' WHERE `option_id`='op-$id.2'");
			mysql_query("UPDATE `questions_options` SET `options`='$ops_3' WHERE `option_id`='op-$id.3'");
			mysql_query("UPDATE `questions_options` SET `options`='$ops_4' WHERE `option_id`='op-$id.4'");
		
			header("location:exam_options.php?qid=$id");
			exit();
			
}

?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title> OS | <?php echo $title; ?> </title>

		<link href="style/css/index.css" rel="stylesheet "/>
		<link href="style/css/category.css" rel="stylesheet "/>		
		<link rel="shortcut icon" href="style/img/favicon.ico">
	</head>
	
	<body>
	<?php
		include "sub_index.php";
	?>
	<div class="control_center_top">
		<div class="control_center_top_inside">
			&nbsp;&nbsp;<span class="control_center_top_text_left"><a href=""><?php echo $title; ?></a></span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="result.php"><img class="control_center_top_ico_result" src="style/img/result.png" title="Result Archive"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit" alt="ico"></a>
		</div>
	</div>

	<div class="CategoryContent">
		<div class="categoryBar">

			<form action="exam_edit.php" enctype="multipart/form-data" name="myForm" id="myForm" method="POST">
			<table class="CategoryEditInside" width="90%" border="0">

			<?php echo $qidInfo;?>
			<?php echo $oidInfo;?>
			<tr>
        		<td width="20%">&nbsp;</td>
            	<td width="80%"><label> <input name="button" type="submit" id="button" value="Update!"></label></td>
        	</tr>
        	</table>
        	<input name='thisID' type='hidden' value='<?php echo $qid; ?>'>
			</form>
			<br/>

		</div>		
	</div>

	


	</div>
	<p class="bottomText">&#169;&nbsp;<a href="http://localhost/OnlineSchool/">Online School</a></p>
		
		
	</body>
</html>