<?php
	session_start();
	$con = mysqli_connect("localhost", "root", "", "cdmis");
	$active = $_POST['active'];
	if ($active == "all") {
		$query = "SELECT * FROM ingredients join measurements where measurements.measurementID=ingredients.measurementID ORDER BY ingredient_name ASC";
	}

	$results = mysqli_query($con, $query);
	$i = 0;
	$rows = mysqli_num_rows($results);
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
			if ($pagenum > 1) {
				$previous = $pagenum - 1;
				$paginationCtrls .= '<li onclick="liveSearch('.$previous.')"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
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
		}
		$paginationCtrls .= '</ul></nav>';
	} else if ($rows == 0) {
		echo "<tr><td colspan='4'>Your search did not match any records.</td></tr>";
	}

	$result=mysqli_query($con,$query);
	while ($row = mysqli_fetch_assoc($result)) {
		$id = $row["ingredient_id"];
		$name= $row["ingredient_name"];
		echo "<tr>
			<td>" . $row["ingredient_name"] . "</td>
				<td>" . $row["ingredient_quantity"] . " " . $row["measurementName"] . "</td>
			<td><span class='icons'><a href='#' onclick=editIngredient('".$id."') data-target='#editModal' data-toggle='modal'><img src='imgs/edit.png'/></a>
				<a href='#' onclick=deleteIngredient('".$id."') data-target='#deleteModal' data-toggle='modal'><img src='imgs/delete.png'/></a></span></td>								
			</tr>";	
	}
	echo "<tr><td colspan='3'>" . $paginationCtrls . "</td></tr>";
?>