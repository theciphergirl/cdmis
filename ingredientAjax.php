<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$search=$_POST['search'];
	$active = $_POST['active'];
	if ($active == "Ingredient") {
		$query = "SELECT * FROM ingredients, measurements WHERE measurements.measurement_id=ingredients.measurement_id ORDER BY ingredient_name ASC";
	}
	if ($active == "") {
		$query = "SELECT * FROM ingredients, measurements WHERE ingredient_name LIKE '%".$search."%' AND measurements.measurement_id=ingredients.measurement_id ORDER BY ingredient_name ASC";
	}

	$result = $db->select($query);
	$i = 0;
	$rows = $db->affected($result);
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
		$id = $row["ingredient_id"];
		$name= $row["ingredient_name"];
		echo "<tr>
			<td>" . $row["ingredient_name"] . "</td>
				<td>" . $row["ingredient_quantity"] . " " . $row["measurement_name"] . "</td>
			<td><span class='icons'><a href='#' onclick=deleteIngredient('".$id."') data-target='#deleteModal' data-toggle='modal'><img src='imgs/delete.png'/></a>
				<a href='#' data-target='#viewModal' data-toggle='modal' onclick='viewIngredient(".$id.")'><img src='imgs/view.png'/></a></span></td>
			</tr>";
	}
	echo "<tr><td colspan='3'>" . $paginationCtrls . "</td></tr>";
?>