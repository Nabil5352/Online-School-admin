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
//category list
$catSQL = mysql_query("SELECT * FROM category ORDER BY Category_id");
$cat_list="";
$sc_list="";

while($row = mysql_fetch_array($catSQL)) {
$catID = $row['Category_id'];
$catName = $row['Category_name'];
$catDesc = $row['Category_desc'];
		
$cat_list .= "<table class='CategoryContentInside' width='90%' border='0'>	
			<tr>
				<td width='100' align='center'>$catID</td>
				<td width='100'><a href='subcategory.php?catid=$catID'>$catName</a></td>
				<td class='BarContent' width='200'>$catDesc</td>
				<td width='100' align='center'>
				<a href='edit.php?editcat&cid=$catID'><img class='action_ico' src='style/img/edit.png' title='Edit' alt='ico'>
				</a> &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp; 
				<a href='delete.php?deletecat=$catID'><img class='action_ico' src='style/img/delete.png' title='Delete' alt='ico'></a> 
				</td>
			</tr>				
			</table>";						
}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title> OS | Category Manager </title>
		<link href="style/css/index.css" rel="stylesheet "/>
		<link href="style/css/category.css" rel="stylesheet "/>		
		<link rel="shortcut icon" href="style/img/favicon.ico">
	</head>
	
	<body>
	<?php
		$title = "Category Manager";
		include "sub_index.php";
	?>

	<div class="control_center_top">
		<div class="control_center_top_inside">
			&nbsp;&nbsp;<span class="control_center_top_text_left"><a href="category.php">Category</a></span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit" alt="ico"></a>
			<a href="addNew.php?option=1"><img class="control_center_top_ico" src="style/img/new.png" title="New" alt="ico"></a>
		</div>
	</div>

	<div class="CategoryContent">
		<div class="categoryBar">
			<table class="CategoryBarInside" width="90%" border="0">
			<tr>
				<td class="BarTitle" width="100" align='center'>Category ID</td>
				<td class="BarTitle" width="100">Category Name</td>
				<td class="BarTitle" width="200" align='center'>Category Desc</td>
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