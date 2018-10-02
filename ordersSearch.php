<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$active = $_POST['active'];

	if ($active == "all") {
		$query = "SELECT * FROM orders WHERE order_date=CURDATE() ORDER BY order_id ASC";
	} else if ($active == "paid"){
		$query = "SELECT * FROM orders WHERE order_date=CURDATE() AND status='Paid'";
	} else if ($active == "not-paid") {
		$query = "SELECT * FROM orders WHERE order_date=CURDATE() AND status='Not Paid'";
	}

	$results = $db->select($query);
	$i = 0;
	$rows = $db->affected();
	$paginationCtrls = '';
	if ($rows > 10) {
		$page_rows = 10;
		$last = ceil($rows/$page_rows);
		$pagenum = 1;
		if(isset($_POST['page'])){
			$pagenum = preg_replace('#[^0-9]#', '', $_POST['page']);
		}
		if ($pagenum < 1) {
			$pagenum = 1;
		} else if ($pagenum > $last) {
			$pagenum = $last;
		}

		$limit = ' LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
		$paginationCtrls = '<nav><ul class="pagination">';
		$query = $query . $limit;
		if($last != 1){
			$previous = $pagenum - 1;
			if($pagenum == 1){
				$paginationCtrls .= '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			}
			else if ($pagenum > 1) {
				$paginationCtrls .= '<li onclick=liveSearch2('.$previous.',"'.$active.'")><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
				for($i = 0; $i < $pagenum; $i++){
					if($i > 0){
						$paginationCtrls .= '<li onclick=liveSearch2('.$i.',"'.$active.'")><a href="#">'.$i.'</a></li>';
					}
				}
			}
			$paginationCtrls .= '<li class="disabled"><a href="#">'.$pagenum.'</a></li>';
			for($i = $pagenum+1; $i <= $last; $i++){
				$paginationCtrls .= '<li onclick=liveSearch2('.$i.',"'.$active.'")><a href="#">'.$i.'</a></li>';
			}
			if ($pagenum != $last) {
				$next = $pagenum + 1;
				$paginationCtrls .= '<li onclick=liveSearch2('.$next.',"'.$active.'")><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			}
			else {
				$paginationCtrls .= '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			}
		}
		$paginationCtrls .= '</ul></nav>';
	} else if ($rows == 0) {
		echo "<tr><td colspan='4'>Your search did not match any records.</td></tr>";
	}
	$query = $db->select($query);
	while($row = $db->fetch($query)) {
		$order_id=$row['order_id'];
		$discounted_total = $row['bill']-($row['bill']*($row['discount']/100));
		echo "<tr id='$order_id' onclick ='openOrder($order_id)'>
				<td>".$row['table_number']."</td>
				<td>".$row['status']."</td>
				<td>".number_format($discounted_total, 2)."</td>
			  </tr>";
	}
	echo "<tr><td colspan='3'>" . $paginationCtrls . "</td></tr>";
?>
