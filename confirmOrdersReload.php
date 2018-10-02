<?php
	session_start();
	$con=mysqli_connect("localhost","root","","cdmis");
	$cat = $_POST['category'];
	$result=mysqli_query($con,"select * from orders_item join orders join menu where orders.order_id=orders_item.order_id and menu.menu_id=orders_item.menu_id 
								and confirmation_status=0 and category='$cat'");
	if(mysqli_affected_rows($con)==0){
		echo "<tr><td>No items to show.</td></tr>";
	}
	else{
		while($row=mysqli_fetch_assoc($result)){
			$orders_item_id=$row['orders_item_id'];	
			echo '<tr>
					<td>'.$row['table_number'].'</td>
					<td>'.$row['menu_name'].'</td>
					<td>'.$row['order_quantity'].'</td>
					<td><button class="btn btn-success" onclick="confirm('.$orders_item_id.')">Confirm</button></td>
				  </tr>';
		}
	}
?>