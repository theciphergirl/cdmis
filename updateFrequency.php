<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$account_name = $_SESSION['account_name'];
	$account_id = $_SESSION['account_id'];
	$order_id=$_POST['id'];
	$qty = $db->select("SELECT menu.menu_id, order_quantity FROM orders_item, menu WHERE menu.menu_id=orders_item.menu_id AND orders_item.order_id = $order_id");
	if($db->affected() > 0){
		while($item=$db->fetch($qty)){
			$m_id = $item['menu_id'];
			$o_qty = $item['order_quantity'];
			$db->query("UPDATE menu SET frequency=frequency+$o_qty WHERE menu_id=$m_id");
		}
	}
?>