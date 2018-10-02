<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$account_id = $_SESSION['account_id'];
	$account_name = $_SESSION['account_name'];

	$order_id=$_GET['cancelBtn'];
	$db->query("DELETE FROM orders_item where order_id='$order_id'");
	
	if($db->affected() > 0){
		$db->query("DELETE from orders where order_id='$order_id'");
		if($db->affected() > 0){
			$logMsg = "cancelled order of table ".$table_number. ".";
			$db->query("INSERT INTO logs VALUES(0, '$logMsg', $account_id, NOW())");
		}
	}
	header("location:orders.php");
?>