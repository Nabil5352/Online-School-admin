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
//edit value

if(isset($_GET['editcat'])){
	if(isset($_GET['cid'])){
				$title = "Edit Category";
				$id = $_GET['cid'];
				
				//Get data from database
				$sql=mysql_query("SELECT * FROM category WHERE Category_id='$id' LIMIT 1");
				$itemCount = mysql_num_rows($sql);
				if($itemCount > 0){
				while($row = mysql_fetch_array($sql)){
				
				$catName = $row['Category_name'];
				$catDesc = $row['Category_desc'];
				}
				$sidInfo = "";				
				$cidInfo = 
				"<tr>
				<td width='20%'>Cateogry Name:</td>
				<td> <input name='category_name' type='text' id='category_name' value='$catName' size='25'></td>
				</tr>
				<tr>
				<td width='20%'>Cateogry Description:</td>
				<td width='80%'><label> <textarea name='desc' id='desc' cols='64' rows='5'>$catDesc</textarea></label></td>
				</tr>
				<input name='thisID' type='hidden' value='$id'>";	
				}
			}
}
else if(isset($_GET['editsubcat'])){
	if(isset($_GET['sid'])){
				$title = "Edit Subcategory";
				$id = $_GET['sid'];
				
				//Get data from database
				$sql=mysql_query("SELECT * FROM subcategory WHERE Subcategory_id='$id' LIMIT 1");
				
				$itemCount = mysql_num_rows($sql);
				if($itemCount > 0){
				while($row = mysql_fetch_array($sql)){
				
				$catID = $row['Category_id'];
				$subcatID = $row['Subcategory_id'];
				$subcatName = $row['Subcategory_name'];
				$meta = $row['meta'];
				}
				
				$cidInfo = "";				
				$sidInfo = 
				"<tr>
				<td width='20%'>Subcategory ID:</td>
				<td width='80%'><label>$id</label></td>
				</tr>
				<tr>
				<td width='20%'>Subcategory Name:</td>
				<td width='80%'><label><input name='subName' type='text' id='subName' value='$subcatName' size='20'></label></td>
				</tr>
				<tr>
				<td width='20%'>Meta:</td>
				<td width='80%'><label> <textarea name='meta' id='meta' cols='64' rows='5'>$meta</textarea></label></td>
				</tr>
				<input name='thisID' type='hidden' value='$id'>
				<input name='thisCID' type='hidden' value='$catID'>
				<input name='subID' type='hidden' value='$subcatID'>";		
				}
			}
}

//update value
//category
if(isset($_POST['category_name'])){
			$id = mysql_real_escape_string($_POST['thisID']);
			$category_name = mysql_real_escape_string($_POST['category_name']);
			$desc = mysql_real_escape_string($_POST['desc']);
			
			$sql = mysql_query("UPDATE category SET Category_name='$category_name', Category_desc='$desc' WHERE Category_id='$id'");
			
			if($sql){
			header('location:category.php');
			exit();
			}
			else{
			echo "Error";
			}
}
//subcategory	
else if(isset($_POST['subID'])){
			$id = mysql_real_escape_string($_POST['thisID']);
			$catid = mysql_real_escape_string($_POST['thisCID']);
			$subID = mysql_real_escape_string($_POST['subID']);
			$subName = mysql_real_escape_string($_POST['subName']);
			$meta = mysql_real_escape_string($_POST['meta']);
			
			$sql = mysql_query("UPDATE `subcategory` SET `Subcategory_name`='$subName',`meta`='$meta' WHERE `Subcategory_id`=$subID");			
			
			if($sql){
			header("location:subcategory.php?catid=$catid");
			exit();
			}
			else{
			echo "Error";
			}
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
			&nbsp;&nbsp;&nbsp;&nbsp;<span class="control_center_top_text"> <?php echo $title; ?></span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit" alt="ico"></a>
		</div>
	</div>

	<div class="CategoryContent">
		<div class="categoryBar">

			<form action="edit.php" enctype="multipart/form-data" name="myForm" id="myForm" method="POST">
			<table class="CategoryEditInside" width="90%" border="0">

			<?php echo $cidInfo;?>
			<?php echo $sidInfo;?>
			<tr>
        		<td width="20%">&nbsp;</td>
            	<td width="80%"><label> <input name="button" type="submit" id="button" value="Update!"></label></td>
        	</tr>
        	</table>
			</form>
			<br/>

		</div>		
	</div>

	


	</div>
	<p class="bottomText">&#169;&nbsp;<a href="http://localhost/OnlineSchool/">Online School</a></p>
		
		
	</body>
</html>