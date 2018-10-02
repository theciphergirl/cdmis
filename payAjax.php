<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$account_name = $_SESSION['account_name'];
	$account_id = $_SESSION['account_id'];
	$order_id=$_POST['id'];
	$query = $db->select("SELECT * FROM orders WHERE order_id='$order_id'");
	$result = $db->query("UPDATE orders SET status = 'Paid' WHERE order_id = $order_id");
	if($db->affected() > 0){
		$logMsg = "updated bill status of table number ".$row['table_number']. " as Paid.";
		$db->query("INSERT INTO logs VALUES(0, '$logMsg', $account_id, NOW())");
		if($db->affected() > 0){
			echo "success";
		}
	}
?>