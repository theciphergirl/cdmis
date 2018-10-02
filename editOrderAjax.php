<?php
	$con=mysqli_connect("localhost","root","","cdmis");
	$order_id=$_POST['order_id'];
	$result = mysqli_query($con,"SELECT * FROM orders AS o INNER JOIN orders_item AS oi ON oi.order_id = o.order_id INNER JOIN menu as m ON m.menu_id = oi.menu_id where o.order_id =$order_id");
	$row=mysqli_fetch_assoc($result);
	$table_number=$row['table_number'];
	$order_quantity=$row['order_quantity'];
	$price=$row['price'];
	$bill=$row['bill'];
	echo "<form method='post'><table>
						<tr><td>Table Number:</td><td><input type='text' name='table_number' value='$table_number'></td></tr>
						<tr><td>Quantity:</td><td><input type='text' name='order_quantity' value='$order_quantity'></td></tr>
						<tr><td>Price:</td><td><input type='text' name='price' value=$price></td></tr>
						<tr><td>Bill:</td><td><input type='text' name='bill' value=$bill></td></tr>
						<tr><td></td><td><input type='submit' name='edit_order' value='Edit Order'></td></tr>
				</table></form>";
?>