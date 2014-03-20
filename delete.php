<?php
include "xtra/connect.php";

//delete category item	
if(isset($_GET['deletecat'])){
	$id_to_delete = $_GET['deletecat'];
	$sql = mysql_query("DELETE FROM category WHERE Category_id='$id_to_delete' LIMIT 1") or die('Error: Could not delete.');
	
		header("location:category.php");
		exit();
	}

//delete subcategory item	
else if(isset($_GET['deletsubcat'])){
	$cid = $_GET['cid'];
	$id_to_delete = $_GET['deletsubcat'];
	$sql = mysql_query("DELETE FROM subcategory WHERE Subcategory_id='$id_to_delete' LIMIT 1") or die('Error: Could not delete.');
	
		header("location:subcategory.php?catid=$cid");
		exit();
	}
else{
	header("location:category.php");
	exit();
}
?>