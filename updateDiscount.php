<?php
	require_once "database/database.php";
	$db = new Database();
	$discount=$_POST['discount'];
	$orderID=$_POST['orderID'];
	$result = $db->query("UPDATE orders SET discount = $discount WHERE order_id = $orderID");
	if($db->affected() > 0){
		$order_details = $db->query("SELECT * FROM orders WHERE order_id = $orderID AND discount = $discount");
		if($db->affected() > 0){
		//	while($details=$db->fetch($order_details)){
				echo "<h3><small><p>Subtotal: Php <span id='subtotal'>".(number_format($details['bill'], 2))."</span></p>
					<p>Discount: <span id='discount'>".$details['discount']."</span>%</p></small>

					<p>TOTAL: Php <span id='total'>".(number_format(($details['bill']-(($details['discount']/100) * $details['bill'])), 2))."</span></h3>";
	//		}
		}
	} else {
		echo "error";
	}
//	header("location:orders.php");
?>
