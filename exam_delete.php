<?php
include "xtra/connect.php";

//delete questions and options
if(isset($_GET['all'])){
	$id_to_delete = $_GET['qid'];
	$sql = mysql_query("DELETE FROM `questions` WHERE `ques_id`='$id_to_delete' LIMIT 1") or die('Error: Could not delete.');
	
		header("location:exam_questions.php");
		exit();
	}

?>