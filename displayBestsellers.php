<ul class="nav nav-tabs pads-top">
	<?php
	$result=$db->select("SELECT month(order_date) AS month FROM orders GROUP BY month(order_date),year(order_date) ORDER BY year(order_date) DESC,month(order_date) ASC LIMIT 5");
	$num=$db->affected();
	$i=1;
	if($num > 0){
		while($row=$db->fetch($result)){
			$monthNum=$row['month'];
			$monthName=date('F', mktime(0,0,0, $monthNum,10));
			if($i!=$num){
				echo "<li><a data-toggle='tab' href='#tab".$i."'>".$monthName."</a></li>";
			}
			else{
				echo "<li class='active'><a data-toggle='tab' href='#tab".$i."'>".$monthName."</a></li>";
			}
			$i+=1;
		}
	}
	else{
		echo "<li class='active'><a data-toggle='tab' href='#tab".$i."'>".date("F", strtotime('m'))."</a></li>";
	}
	?>
</ul>

<div class="tab-content clearfix">
	<?php
		$result2=$db->select("select month(order_date) as month,year(order_date) as year from orders group by month(order_date),year(order_date) order by year(order_date) desc,month(order_date) asc limit 5");
		$j=1;
		echo '';
		if($db->affected() > 0){
			while($row2=$db->fetch($result2)){
				$monthNum=$row2['month'];
				$yearNum=$row2['year'];
				if ($j==$num){
					echo "<div id='tab".$j."' class='tab-pane fade in active'>";
				}
				else{
					echo "<div id='tab".$j."' class='tab-pane fade'>";
				}
	?>
		<div class='panel-heading'>
				Top 10 Bestsellers for This Month
		</div>

		<table class='table table-striped'>
			<thead>
				<tr>
					<th class='col-md-7'>Name</th>
					<th>Sold</th>
				</tr>
			</thead>
			</tbody>
	<?php
				$result=$db->select("SELECT menu_name,sum(order_quantity) as total FROM `orders` join orders_item join menu where menu.menu_id=orders_item.menu_id and orders.order_id=orders_item.order_id and year(order_date)=$yearNum and month(order_date)=$monthNum group by menu_name order by total desc limit 10");
				while($row=$db->fetch($result)){
					echo "<tr>
							<td>".$row['menu_name']."</td>
							<td>".$row['total']."</td>
						  </tr>";
				}

				echo "</tbody></table></div>";
				$j+=1;

			}
		}
		else{?>
			echo "<br	/><hr	/>
			<div class='panel-heading center'>
				No Bestsellers found for this month
			</div>
			<hr	/><br	/>";
	<?php	}?>
		</div>
	</div>