<?php

	$db = mysql_connect('localhost','root','nabil');
		
		if(!$db){
			echo "ERROR: Could not connect to database. Please try again later.";
			exit;
		}
	

?>