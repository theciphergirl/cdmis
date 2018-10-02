<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$order_id=$_POST['order_id'];
	$result = $db->select("SELECT * FROM orders AS o INNER JOIN orders_item AS oi ON oi.order_id = o.order_id INNER JOIN menu as m ON m.menu_id = oi.menu_id where o.order_id =$order_id");
	if($db->affected() != 0){
		$row=$db->fetch($result);
		$status = $row['status'];
		$current = $row['price'];
		echo "<h4>VIEWING TABLE #<span id='hidden'>".$row['table_number']."</span> - ".$row['status']." </h4>
				<div class='well well-primary'>
					<div class='panel panel-default'>
						<table class='table table-striped' id='Order_Table'>
							<thead>
								<tr>
									<th></th>
									<th>Qty</th>
									<th>Price</th>
									<th>Total</th>
								</tr>
							</thead>
				<tbody id='order-list'>";

		$result2 = $db->select("SELECT * FROM orders AS o INNER JOIN orders_item AS oi ON oi.order_id = o.order_id INNER JOIN menu as m ON m.menu_id = oi.menu_id where o.order_id =$order_id");
		if($db->affected() != 0){
			while($rows=$db->fetch($result2)){
				$menu_name=$rows['menu_name'];
				echo	"<tr>
					<td>".$rows['menu_name']."</td>
					<td class='col-md-2'>";
					if(/*$rows['confirmation_status']==0 AND */$rows['status'] == 'Not Paid'/* AND $rows['paid_quantity']==0*/){
						echo " <input type='number' value='".$rows['order_quantity']."' min='1' class='form-control' onchange='change_quantity(this)'/></td>";
					} else {
						echo $rows['order_quantity']. "</td>";
					}
					echo "<td > Php ".number_format($rows['price'],2)."</td>
					<td>Php <span name='itemtotal'>".number_format(($rows['order_quantity']*$rows['price']),2)."</span></td>
					<input type='hidden' name='price' value='".$rows['price']."' />
					<input type='hidden' name='quantity' value='".$rows['order_quantity']."' />
					<input type='hidden' name='menu-id' value='".$rows['menu_id']."' />
					<input type='hidden' name='itemtotal 'value='".($rows['order_quantity']*$rows['price'])."' />";
					if(/*$rows['confirmation_status']==0 AND */$rows['status'] == 'Not Paid'/* AND $rows['paid_quantity']==0*/){
						echo "<td><a href='#'><button type='button' class='btn btn-danger orderRemove' onclick='remove_order(".$rows['item_id'].",".$rows['order_id'].",\"".$menu_name."\",".$rows['order_quantity'].",".$rows['price'].",this)'>x</button></a></td>";

					}
			/*		else if($rows['confirmation_status']==1 AND $rows['status'] == 'Not Paid' AND $rows['paid_quantity']==0){
						echo "<td><a href='#'><button type='button' class='btn btn-success' name='pay_indiv_order' onclick='pay_individual_order(".$rows['orders_item_id'].",".$rows['order_id'].",\"".$menu_name."\",".$rows['order_quantity'].",".$rows['price'].")'>Pay</button></a></td>";
					}*/
					else{
						echo "<td></td><td></td>";
					}

				echo "</tr>";
			}
			echo"</tbody>
				</table>
				</div>
				<div id='computation' class='pad-top text-right'>
				<h3><small><p>Subtotal: Php <span id='subtotal'>".(number_format($row['bill'], 2))."</span></p>
				<p>Discount: <span id='discount'>".$row['discount']."</span>%</p></small>

				<p>TOTAL: Php <span id='total'>".(number_format(($row['bill']-(($row['discount']/100) * $row['bill'])), 2))."</span></h3>
				</div>";
			if($status == 'Not Paid') {
				echo "<hr>

				<button type='button' class='btn btn-danger' name='cancel_order' onclick='Cancel_Order($order_id)'>Cancel Order</button>
				<button type='button' class='btn btn-success' name='pay' onclick='Pay($order_id)'>Pay</button>
				<button id='confirm' type='button' class='btn btn-success' onclick='confirmOrder($order_id)' style='display:none;'>Confirm Order</button>
				<button id='add_unpaid' type='button' onclick=liveSearch(1,'') class='btn btn-warning' name='add_order' data-target='#addingModal' data-toggle='modal'>Add Order</button>
				<button id='discount' type='button'  onclick=placeOrderID($order_id) class='btn btn-warning' data-target='#discountModal' data-toggle='modal'>";
					if($row['discount'] > 0){	echo "Change Discount";	}
					else{	echo "Add Discount"; }	
				echo "</button>

					</div>";
			} else {

				echo "<hr>
					<h2> PAID </h2>
				</div>";

			}
		}
	}
?>
