<?php
	$con=mysqli_connect("localhost","root","","cdmis");
	$order_id=$_GET['order_id'];
	$orders_item_id=$_GET['orders_item_id'];
	$total=$_GET['total_id'];
	$paid_qty=$_GET['qtyID'];
	//$result=mysqli_query($con,"SELECT price FROM orders_item join menu where menu.menu_id=orders_item.menu_id and orders_item.orders_item_id=$orders_item_id");
	//$row=mysqli_fetch_assoc($result);
	//$price=$row['price'];
	
	//mysqli_query($con,"UPDATE orders set bill=bill-$total WHERE order_id='$order_id'");
	$result=mysqli_query($con,"SELECT order_quantity,menu_id,confirmation_status FROM orders_item where orders_item_id=$orders_item_id");
	$row=mysqli_fetch_assoc($result);
	$order_qty=$row['order_quantity'];
	$menu_id=$row['menu_id'];
	$confirmation_status=$row['confirmation_status'];
	$remaining_qty=$order_qty-$paid_qty;
	if($remaining_qty>0){
		mysqli_query($con,"INSERT into orders_item VALUES (0,$order_id,$menu_id,$remaining_qty,$confirmation_status,0)");
	}
	mysqli_query($con,"UPDATE orders_item set paid_quantity=$paid_qty,order_quantity=$paid_qty where orders_item_id='$orders_item_id'");
	mysqli_query($con,"UPDATE orders set bill=bill-$total where order_id='$order_id'");
	header("location:orders.php");
?>