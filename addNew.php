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

//addItem
if(isset($_GET['addcat'])){
		//For category only

		$cat_name = $_POST['category_name'];
		$desc = $_POST['desc'];

		if(!$cat_name || !$desc){
			header('location: addNew.php?option=1');
			exit();
		}
		else{			
		$category_name = mysql_real_escape_string($cat_name);
		$catdesc = mysql_real_escape_string($desc);
	
		$sql = mysql_query("INSERT INTO `category`(`Category_name`, `Category_desc`) VALUES ('$category_name','$catdesc')");

		if(!$sql){
		die('Error:Cannot insert data into database.');
		}

		header("location:category.php");
		exit();
		}
	}
	else if(isset($_GET['addsubcat'])){
	//For subcategory only

		$categoryID = $_POST['catid'];
		$reqested_id = $_POST['subcat_sequence_id'];

		$subcategoryName = $_POST['subName'];
		$meta = $_POST['meta'];

		if(!$subcategoryName || !$meta){
			header("location: addNew.php?option=2&cid=$categoryID");
			exit();		
		}
		else{
		$subcategory_name = mysql_real_escape_string($subcategoryName);
		$subID = mysql_real_escape_string($meta);
	
		$sql = mysql_query("INSERT INTO `subcategory`(`Category_id`, `Subcategory_id`, `Subcategory_name`, `meta`) VALUES ($categoryID,'$reqested_id','$subcategory_name','$meta')");

		if(!$sql){
		die('Error:Cannot insert data into database.');
		}

		header("location:subcategory.php?catid=$categoryID");
		exit();			
		}
}

?>

<?php

$catup = "<!--";
$catdown = "-->";

$subcatup = "<!--";
$subcatdown = "-->";

if(isset($_GET['option'])){

	$value = $_GET['option'];

	if($value==1){
		$toptitle = "Category";
		$catup = "";
		$catdown = "";
	}

	else if($value==2){
		$catid = $_GET['cid'];

		$requested_cat_name_sql = mysql_query("SELECT * FROM `category` WHERE `Category_id`=$catid LIMIT 1");

		while($row = mysql_fetch_array($requested_cat_name_sql)){
			$requested_cat_name = $row['Category_name'];
		}

		$subcat_sequence = mysql_query("SELECT * FROM `subcategory` WHERE `Category_id`=$catid ORDER BY `Subcategory_id` DESC LIMIT 1");

		while($row = mysql_fetch_array($subcat_sequence)){
			$subcat_sequence_id = $row['Subcategory_id'];
		}

		$secondSQL = mysql_query("SELECT count(Subcategory_id) FROM `subcategory` WHERE `Category_id`=$catid");
		$count = mysql_result($secondSQL,0);
		{
			if ($count < 1){
				$subcat_sequence_id = $catid;
			}
		}

		$subcat_sequence_id = $subcat_sequence_id + .1;

		$toptitle = "Subcategory";
		$subcatup = "";
		$subcatdown = "";
	}
}
else{
	header('location: category.php');
	exit();
}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title> OS | Add New </title>
		<link href="style/css/index.css" rel="stylesheet "/>
		<link href="style/css/category.css" rel="stylesheet "/>		
		<link rel="shortcut icon" href="style/img/favicon.ico">
	</head>
	
	<body>
	<?php
		$title = "Add New ".$toptitle;
		include "sub_index.php";
	?>

	<div class="control_center_top">
		<div class="control_center_top_inside">
			&nbsp;&nbsp;&nbsp;&nbsp;<span class="control_center_top_text"> Add New <?php echo $toptitle; ?> </span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit" alt="ico"></a>
		</div>
	</div>

	<div class="addNewContent">
		<div class="addNewBar">

			<!-- category form -->		
		<?php
			echo $catup;
		?>
		<h3 class="titleHead">Add New Category:</h3>
		
	<form class="form" action="addNew.php?addcat" enctype="multipart/form-data" name="myForm" id="myForm" method="POST">	
	   <table width="90%" border="0" cellspacing="0" cellpadding="0">
		<tr>
        	<td width="20%">Name:</td>
			<td> <input name="category_name" type="text" id="category_name" size="25"></td>
        </tr>
        <tr>
        	<td width="20%">Description:</td>
            <td width="80%"><label> <textarea name="desc" id="desc" cols="64" rows="5"></textarea></label></td>
        </tr>
        <tr>
        	<td width="20%">&nbsp;</td>
            <td width="80%"><label> <input name="button" type="submit" id="button" value="Add!"></label></td>
        </tr>       
       </table>
	</form>
		<?php
			echo $catdown;
		?>

		<!-- subcategory form -->		
		<?php
			echo $subcatup;
		?>
		<h3 class="titleHead">Add New Subcategory:</h3>
		
	<form class="form" action="addNew.php?addsubcat" enctype="multipart/form-data" method="POST">	
	   <table width="90%" border="0" cellspacing="0" cellpadding="0">
	   	<tr>
        	<td width="20%">Category:</td>
            <td><label class='requested_cat_name'><i><b><?php echo $requested_cat_name; ?></b></i></label></td>
        </tr>
		<tr>
        	<td width="20%">Auto ID:</td>
            <td width="80%"><label class='subcat_sequence_id'><i><b><?php echo $subcat_sequence_id; ?></b></i></label></td>
        </tr>
		<tr>
        	<td width="20%">Name:</td>
           <td width="80%"><label><input name="subName" type="text" id="subName" size="20"></label></td>
        </tr>
        <tr>
        	<td width="20%">Description:</td>
            <td width="80%"><label> <textarea name="meta" id="meta" cols="64" rows="5"></textarea></label></td>
        </tr>
        <input type='hidden' name='catid' value='<?php echo $catid; ?>'/>
        <input type='hidden' name='subcat_sequence_id' value='<?php echo $subcat_sequence_id; ?>'/>
        <tr>
        	<td width="20%">&nbsp;</td>
            <td width="80%"><label> <input name="button" type="submit" id="button" value="Add!"></label></td>
        </tr>       
       </table>

	</form>
		<?php
			echo $subcatdown;
		?>

		</div>
	</div>

	</div>
	<p class="bottomText">&#169;&nbsp;<a href="http://localhost/OnlineSchool/">Online School</a></p>
		
		
	</body>
</html>