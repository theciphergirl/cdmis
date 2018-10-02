<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$search = $_POST['search'];
	$active = $_POST['active'];

	if ($active == "all") {
		$query = "SELECT * FROM menu WHERE menu_name like '%$search%' ORDER BY frequency DESC";
	} else if ($active == "All-day"){
		$query = "SELECT * FROM menu WHERE category = 'all-day-breakfast' AND menu_name like '%$search%' ORDER BY frequency DESC";
	} else if ($active == "Drinks") {
		$query = "SELECT * FROM menu WHERE category = 'drinks' AND menu_name like '%$search%' ORDER BY frequency DESC";
	} else if ($active == "Pizza") {
		$query = "SELECT * FROM menu WHERE category = 'pizza-quesadillas' AND menu_name like '%$search%' ORDER BY frequency DESC";
	} else if($active == "Waffles"){
		$query = "SELECT * FROM menu WHERE category = 'waffles-pancakes' AND menu_name like '%$search%' ORDER BY frequency DESC";
	} else if($active == "Others"){
		$query = "SELECT * FROM menu WHERE category = 'others' AND menu_name like '%$search%' ORDER BY frequency DESC";
	}

	$results = $db->select($query);
	$i = 0;
	$rows = $db->rows($results);
	$paginationCtrls = '';
	if ($rows > 6) {
		$page_rows = 6;
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
			else{
				$paginationCtrls .= '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			}
		}
		$paginationCtrls .= '</ul></nav>';
	} else if ($rows == 0) {
		echo "<tr><td colspan='4'>Your search did not match any records.</td></tr>";
	}
	$query = $db->select($query);
	while($row = $db->fetch($query)) {
		echo "<tr>";
		echo "<td>" . $row['menu_name'] . "</td>";
		echo "<input type='hidden' id='mname_". $row['menu_id'] ."' value='". $row['menu_name'] ."'>";
		echo "<td>Php " . $row['price'] . ".00</td>";
		echo "<input type='hidden' id='mprice_". $row['menu_id'] ."' value='". $row['price'] ."'>";
			
		if($row['menu_status'] == 1){
			echo "<td id='addBtn" . $row['menu_id'] . "'><a href='#' onclick=add_menu(". $row['menu_id'] .") data-toggle='modal' data-target='#addOrder'>
				<button type='button' class='btn btn-success'>+</button></a></td>";
		}
		else if($row['menu_status'] == 0){
			echo "<td>
				<button type='button' class='btn disabled' disabled>+</button></td>";
		}
		
		echo "</tr>";
	}
	echo "<tr><td colspan='3'>" . $paginationCtrls . "</td></tr>";
?>
