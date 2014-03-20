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
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $user = $row['username'];
	$pass = $row['password'];
	$email = $row['email'];
	$date = $row['last_log_date'];	
	}   
	
if(!strcmp($user,$admin)==0 && !strcmp($pass,$password)==0)
	{
		header("location:enter_admin.php");
		exit;
	}
?>

<?php

	if(isset($_POST['first_name']) || isset($_POST['last_name']) || isset($_POST['user']) || isset($_POST['pass']) || isset($_POST['email'])){
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$email = $_POST['email'];

	include "xtra/connect.php";

	mysql_query("UPDATE `admin` SET `first_name`='$first_name', `last_name`='$last_name',
		`username`='$user',`password`='$pass',`email`='$email' WHERE `id`=$id LIMIT 1");

	header("location: profile.php");
	exit();
	}
	
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title> OS | My profile </title>
		<link href="style/css/index.css" rel="stylesheet "/>
		<link href="style/css/profile.css" rel="stylesheet "/>
		<link rel="shortcut icon" href="style/img/favicon.ico">
	</head>
	
	<body>
	<?php
		$title = "Profile";
		include "sub_index.php";
	?>

	<div class="control_center_top">
		<div class="control_center_top_inside">
			&nbsp;&nbsp;&nbsp;&nbsp;<span class="control_center_top_text">My profile</span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit" alt="ico"></a>
		</div>
	</div>

		<div class="profileForm">
			
				</h4><form action="profile.php" class="profile" method="post">
				  <table width="74%" border="0" cellpadding="2">
				    <tr>
				      <td width="39%" scope="row">ID:</td>
				      <td width="61%"><label type="text" name="id" id="id"> <?php echo $id; ?> </label></td>
			        </tr>
				    <tr>
				      <td scope="row">First Name:</td>
				      <td> <input type="text" name="first_name" value="<?php echo $first_name; ?>" id="first_name" size="20" maxlength="20"></td>
			        </tr>
				    <tr>
				      <td scope="row">Last Name: </td>
				      <td><input type="text" name="last_name" value="<?php echo $last_name; ?>" id="last_name" size="20" maxlength="20"></td>
			        </tr>
				    <tr>
				      <td scope="row">Log in Name: </td>
				      <td><input type="text" name="user" value="<?php echo $user; ?>" id="user" size="20" maxlength="20"></td>
			        </tr>
				    <tr>
				      <td scope="row">Password:</td>
				      <td><input type="password" name="pass" value="<?php echo $pass; ?>" id="pass" size="20" maxlength="20"></td>
			        </tr>
				    <tr>
				      <td scope="row">E-mail:</td>
				      <td><input type="email" name="email" value="<?php echo $email; ?>" id="email" size="20" maxlength="40"></td>
			        </tr>
				    <tr>
				      <td scope="row">Last Visit: </td>
				      <td><label type="date" name="date" id="date"><?php echo $date; ?> </label></td>
			        </tr>
                    <tr>
				      <td scope="row">&nbsp;</td>
				      <td><input class="submit_ico" type="image" src="style/img/save.png" border="0" alt="SUBMIT!" title="Save"></td>
			        </tr>
			      </table>
            </form>

	</div>

	</div>
	<p class="bottomText">&#169;&nbsp;<a href="http://localhost/OnlineSchool/">Online School</a></p>
		
	</div>
		
	</body>
</html>