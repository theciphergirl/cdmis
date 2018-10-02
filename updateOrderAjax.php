<?php
$con=mysqli_connect("localhost","root","","cdmis");
if(isset($_POST['update_order'])){
	echo "<script>alert('sulod')</script>";
	$order_id=$_POST['order_id'];
	$table_number=$_POST['table_number'];
	$order_quantity=$_POST['order_quantity'];
	$price=$_POST['price'];
	$bill=$_POST['bill'];
	mysqli_query($con,"UPDATE orders AS o JOIN orders_item AS oi JOIN menu as m ON o.order_id = $order_id AND oi.order_id = o.order_id AND m.menu_id = oi.menu_id SET o.table_number = $table_number AND oi.orders_item = $orders_item AND m.price = $price AND o.bill = $bill");
	if (mysqli_affected_rows($con)!=0){
		echo "<script>alert('Item updated successfully')</script>";
	}
	else{
		echo "There was an error";
	}

	header("Location:orders.php");
}

?>