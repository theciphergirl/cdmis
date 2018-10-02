<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$orderID = $_POST['order_id'];
	$itemID = $_POST['orders_item_id'];
	$qty = $_POST['qty'];
 	$total = $_POST['total'];
	$db->query("SELECT * FROM orders_item WHERE item_id = $itemID");
	$item_num = $db->affected();
	
 	$query = "DELETE FROM `orders_item` WHERE item_id = $itemID";
	$query = $db->query($query);
	if($db->affected() > 0){
		if($item_num > 1){
			$result = $db->query("UPDATE orders SET bill = $total WHERE order_id = $orderID");
			if($db->affected() > 0){
				echo $orderID;
			}
		}
		else{
			$db->query("DELETE FROM orders WHERE order_id = $orderID");
			echo "delete";
		}
	}
?>