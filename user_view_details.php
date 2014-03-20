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
if(isset($_GET['uid'])){
	$user_id = $_GET['uid'];

	$sql = mysql_query("select * from user where user_id ='$user_id'");

	while($rows = mysql_fetch_array($sql)){
		$id = $rows['user_id'];
   		$first_name = $rows['first_name'];
   		$last_name = $rows['last_name'];
   		$user_name = $rows['user_name'];
   		$date = $rows['date_of_birth'];
   		$email = $rows['e_mail'];
  		$country = $rows['country'];
	}
	
   	
	$n = ' ';
	$name = $first_name.$n.$last_name;

}

?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title> OS | User Details </title>
 		
 		<link href="style/css/new_modify_for_exam.css" rel="stylesheet"/>
   		<link href="style/css/index.css" rel="stylesheet"/>
   		<link href="style/css/category.css" rel="stylesheet"/>
   		<link href="style/css/profile.css" rel="stylesheet"/>
		<link rel="shortcut icon" href="style/img/favicon.ico">
		</head>
<body>
<?php
		$title = "User Details";
		include "sub_index.php";
?>

	<div class="control_center_top">
		<div class="control_center_top_inside">
			&nbsp;&nbsp;<span class="control_center_top_text_left"><a href="user_profile.php">User Manager</a></span>&nbsp;&nbsp;&nbsp;&#187;&nbsp;
			<span class="control_center_top_text_right"><a href="">User Details</a></span>
			<a href="#"><img class="control_center_top_ico_help" src="style/img/help.png" title="Help" alt="ico"></a>
			<a href="index.php"><img class="control_center_top_ico" src="style/img/cancel.png" title="Close & Exit" alt="ico"></a>
			<a href="user_profile.php"><img class="control_center_top_ico" src="style/img/new.png" title="Create New User" alt="ico"></a>
		</div>
	</div>

<div class="CategoryContent">
	<div class="page_header">User Information</div>
<div class="categoryBar">
	<div class="row-fluid">
	<div class="span3">
    <img class='usrIMG' src="../ste_includes/ste_content/img/sign_img/<?php echo $id;?>.jpg" alt="">
    <p class='usrTXT'>&nbsp;&nbsp;<?php echo $name;?></p>
  </div>  
	      
 

 
  <header class="modal_header" >
	  <table class="" width="50%">
		  
         <tr class="success">
                 <td><span class="badge badge-info">=></span></td>
                 <td>Name:</td>
                <td><?php echo $name;?></td>
               
         </tr>
		  <tr class="success">
                <td><span class="badge badge-info">=></span></td>
                 <td>UserName:</td>
                <td><?php echo $user_name;?></td>
             
         </tr>
		 <tr class="success">
                 <td><span class="badge badge-info">=></span></td>
                 <td>E-mail:</td>
                <td><?php echo $email;?></td>
                
         </tr>	 
		 <tr class="success">
                 <td><span class="badge badge-info">=></span></td>
                 <td>Date of Birth:</td>
                <td><?php echo $date;?></td>
                
         </tr>
		  <tr class="success">
                <td><span class="badge badge-info">=></span></td>
                 <td>Password:</td>
                <td><?php echo $password;?></td>
           
         </tr>
		  <tr class="success">
                <td><span class="badge badge-info">=></span></td>
                 <td>Country:</td>
                <td><?php echo $country;?></td>
           
         </tr>
        <tr class="delSuccess">
                <td></td>
                 <td><br/><a href='user_delete.php?uid=<? echo $id;?>'>Delete user</a></td>        
         </tr>
		  </table>
	  
	</header>
</div>
</div>
</div>			
</div>

</div>
	<p class="bottomText">&#169;&nbsp;<a href="http://localhost/OnlineSchool/">Online School</a></p>
<script src="../style/js/jquery.js"></script>
<script src="../style/js/jquery-ui.js"></script>
<script src="../style/js/exam.js"></script>
</body>
</html>