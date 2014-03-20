<?php
if(isset($_GET['img'])){
	$value = $_POST['destination'];

	if($value=='adminPic'){
		$path = 'style/img/';
	}
	else if($value=='sitePic'){
		$path = '../ste_includes/ste_content/img/';
	}
	else if($value=='profilePic'){
		$path = '../ste_includes/ste_content/img/sign_img/';
	}

	$newname = "1.jpg";
	move_uploaded_file($_FILES['fileField']['tmp_name'],"$path$newname");
	

}
else if(isset($_GET['vid'])){
	$value = $_POST['destination'];

	if($value=='vid'){
		$path = '../ste_includes/ste_content/vid/';
	}

	$newname = "1.jpg";
	move_uploaded_file($_FILES['fileField']['tmp_name'],"$path$newname");
}
?>