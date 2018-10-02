<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$account_id = $_SESSION['account_id'];
	$account_name = $_SESSION['account_name'];

	$table = $_POST['table'];
	$total = $_POST['total'];
	$date = date("Y-m-d");
	$query = "INSERT INTO `orders`(`order_id`, `order_date`, `table_number`, `status`, `bill`, `discount`) VALUES (0,'$date','$table','Not Paid', '$total', 0)";
	$query = $db->query($query);
	$affected = $db->affected();
	$order_id = $db->insertID();
	echo $order_id;
	if($affected == 1){
		$logMsg = "added order of table: ".$table.".";
		$db->query("INSERT INTO logs VALUES(0, '$logMsg', $account_id, NOW())");
	}
?>