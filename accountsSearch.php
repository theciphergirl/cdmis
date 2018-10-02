<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$value=$_POST['value'];
	$sql="SELECT * FROM account where account_name like '%$value%'";
	$result=$db->select($sql);
	if($db->affected() > 0){
		while ($row = $db->fetch($result)) {
			echo "<tr>
			<td>" . $row['account_name'] . "</td>
			<td>";
			if($row['access_type'] == 1){	echo "Admin";	}
			if($row['access_type'] == 2){	echo "Cashier";	}
			echo "</td>
			<td><span class='icons'><a href='#' onclick=editAccount('".$row['account_id']."') data-target='#editModal' data-toggle='modal'><img src='imgs/edit.png'/></a>
				<a href='#' onclick=deleteAccount('".$row['account_id']."') data-target='#deleteModal' data-toggle='modal'><img src='imgs/delete.png'/></a></span></td>								
			</tr>";	
		}
	}
	else{
		echo "<tr><td colspan='3'>No matches found.</td></tr>";
	}
?>
