<?php	@$db = mysql_connect('localhost','root','nabil');				if(!$db){			echo "ERROR: Could not connect to database. Please try again later.";			exit;		}		$db_selected = mysql_select_db('online_school', $db);		if (!$db_selected){        echo "Cannot connect to the database.";        exit;		}	?>