<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$tablenum = $_POST['tablenum'];
	if($tablenum > 20){
		echo "out of bounds";
	}
	else if($tablenum > 0){
		$db->select("SELECT * FROM orders WHERE status = 'Not Paid' AND table_number = $tablenum");
		if($db->affected() > 0){
			echo "taken";
		}
		else{
			echo "available";
		}
	}
	else{
		echo "disabled";
	}
?>