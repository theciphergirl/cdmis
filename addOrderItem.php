<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();

	
	 if (isset($_POST['total'])){
 		$orderID = $_POST['orderID'];
	 	$total = $_POST['total'];
	 	$result = $db->query("UPDATE orders SET bill = $total WHERE order_id = $orderID");
		if($db->affected()!=0){
			echo $orderID;
		}
	 } else {
 		$orderID = $_POST['orderID'];
		$itemID = $_POST['itemID'];
		$qty = $_POST['qty'];
	 	$query = "INSERT INTO `orders_item`(`order_id`, `menu_id`, `order_quantity`) VALUES ('$orderID','$itemID','$qty')";
		$query = $db->query($query);
	 }
?>