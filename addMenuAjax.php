<?php
	require_once "database/database.php";
	$db = new Database();
	$term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends
	$qstring = "SELECT * FROM ingredients WHERE ingredient_name LIKE '%".$term."%'";
	$result = $db->select($qstring);//query the database for entries containing the term

		while ($row = $db->fetch($result))//loop through the retrieved values
		{
			$row_set[] = $row['ingredient_name'];//build an array
		}
		echo json_encode($row_set);
?>