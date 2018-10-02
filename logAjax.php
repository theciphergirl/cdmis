<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$search = $_POST['search'];
	$active = $_POST['active'];
	echo $search;
	if ($active == "Account"){
		$query = "SELECT log_id, log_msg, log_date, account_name FROM logs, account WHERE logs.account_id = account.account_id
				AND log_msg LIKE '%account%' AND (log_msg LIKE '%".$search."%' OR account_name LIKE '%".$search."%') ORDER BY log_id DESC";
	} else if ($active == "Menu") {
		$query = "SELECT log_id, log_msg, log_date, account_name FROM logs, account WHERE logs.account_id = account.account_id 
				AND log_msg LIKE '%menu%' AND (log_msg LIKE '%".$search."%' OR account_name LIKE '%".$search."%') ORDER BY log_id DESC";
	} else if ($active == "Ingredients") {
		$query = "SELECT log_id, log_msg, log_date, account_name FROM logs, account WHERE logs.account_id = account.account_id 
				AND log_msg LIKE '%ingredient%' AND (log_msg LIKE '%".$search."%' OR account_name LIKE '%".$search."%') ORDER BY log_id DESC";
	} else if ($active == "Order") {
		$query = "SELECT log_id, log_msg, log_date, account_name FROM logs, account WHERE logs.account_id = account.account_id 
				AND (log_msg LIKE '%order%' OR log_msg LIKE '%bill%' OR log_msg LIKE '%cancel%' OR log_msg LIKE '%confirm%') AND (log_msg LIKE '%".$search."%' OR account_name LIKE '%".$search."%') ORDER BY log_id DESC";
	} else {
		$query = "SELECT log_id, log_msg, log_date, account_name FROM logs, account WHERE logs.account_id = account.account_id 
				AND (log_msg LIKE '%".$search."%' OR account_name LIKE '%".$search."%') ORDER BY log_id DESC";
	}

	$result = $db->select($query);
	$i = 0;
	$rows = $db->affected($result);
	$paginationCtrls = '';
	if ($rows > 6) {
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
		$result=$db->select($query);
		if($last != 1){
			$previous = $pagenum - 1;
			if($pagenum == 1){
				$paginationCtrls .= '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			}
			else if ($pagenum > 1) {
				$paginationCtrls .= '<li onclick=liveSearch('.$previous.',"'.$active.'")><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			
				for($i = 0; $i < $pagenum; $i++){
					if($i > 0){
						$paginationCtrls .= '<li onclick=liveSearch('.$i.',"'.$active.'")><a href="#">'.$i.'</a></li>';
					}
				}
			}
			$paginationCtrls .= '<li class="disabled"><a href="#">'.$pagenum.'</a></li>';
			for($i = $pagenum+1; $i <= $last; $i++){
				$paginationCtrls .= '<li onclick=liveSearch('.$i.',"'.$active.'")><a href="#">'.$i.'</a></li>';
			}
			if ($pagenum != $last) {
				$next = $pagenum + 1;
				$paginationCtrls .= '<li onclick=liveSearch('.$next.',"'.$active.'")><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			}
			else {
				$paginationCtrls .= '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			}
		}
		$paginationCtrls .= '</ul></nav>';
	} else if ($rows == 0) {
		echo "<tr><td colspan='4'>Your search did not match any records.</td></tr>";
	}

	while ($row =$db->fetch($result)) {
		$logID = $row['log_id'];
		$date = $row['log_date'];
		echo "<tr>
				<td>".$row['account_name']." ".$row['log_msg']."</td>
				<td>".date('M d, Y h:ia ', strtotime($date))."</td>
			  </tr>";
	}
	echo "<tr><td colspan='3'>" . $paginationCtrls . "</td></tr>";
?>