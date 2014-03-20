<?php
include "xtra/connect.php";

if(isset($_GET['uid']) && isset($_GET['xm_id'])){

$user_id = $_GET['uid'];
$exam_id = $_GET['xm_id'];


$sql = mysql_query("DELETE FROM `result_archive` WHERE `user_id`='$user_id' AND `exam_id`='$exam_id'");
header("location:result.php");
exit();
}
else{
	header("location:result_view_details.php?uid=$user_id");
	exit();
}
?>