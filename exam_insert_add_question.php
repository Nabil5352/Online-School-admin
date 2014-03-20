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
$exam_id = $_POST['exam_id'];
$ques_id = $_POST['ques_id'];
$ques_title = $_POST['ques_title'];
$answer = $_POST['answer'];

$option_id1 = $_POST['option_id1'];
$option_id2 = $_POST['option_id2'];
$option_id3 = $_POST['option_id3'];
$option_id4 = $_POST['option_id4'];

$option1 = $_POST['options1'];
$option2 = $_POST['options2'];
$option3 = $_POST['options3'];
$option4 = $_POST['options4'];

if(!$ques_title || !$answer || !$option1 || !$option2 || !$option3 || !$option4){
	header('location: exam.php');
	exit();
}
else{
	$exam_id = mysql_real_escape_string($exam_id);
	$ques_id = mysql_real_escape_string($ques_id);
	$ques_title = mysql_real_escape_string($ques_title);
	$answer = mysql_real_escape_string($answer);

	$option_id1 = mysql_real_escape_string($option_id1);
	$option_id2 = mysql_real_escape_string($option_id2);
	$option_id3 = mysql_real_escape_string($option_id3);
	$option_id4 = mysql_real_escape_string($option_id4);

	$option1 = mysql_real_escape_string($option1);
	$option2 = mysql_real_escape_string($option2);
	$option3 = mysql_real_escape_string($option3);
	$option4 = mysql_real_escape_string($option4);

	$sql = mysql_query("UPDATE `questions` SET `ques_title`='$ques_title',`answer`='$answer' WHERE `exam_id`='$exam_id'");

	if(!$sql){
		die(mysql_error());
	}

	mysql_query("INSERT INTO `questions_options`(`ques_id`, `option_id`, `options`) VALUES ('$ques_id','$option_id1','$option1')");
	mysql_query("INSERT INTO `questions_options`(`ques_id`, `option_id`, `options`) VALUES ('$ques_id','$option_id2','$option2')");
	mysql_query("INSERT INTO `questions_options`(`ques_id`, `option_id`, `options`) VALUES ('$ques_id','$option_id3','$option3')");
	mysql_query("INSERT INTO `questions_options`(`ques_id`, `option_id`, `options`) VALUES ('$ques_id','$option_id4','$option4')");
	
	header('location:exam.php');
	exit();
}

?>