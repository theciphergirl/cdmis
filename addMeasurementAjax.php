<?php
	require_once "database/database.php";
	$db = new Database();
	$term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends
	$qstring = "SELECT * FROM measurements WHERE measurementName LIKE '%".$term."%'";
	$result = $db->select($con,$qstring);//query the database for entries containing the term

		while ($row = $db->fetch($result))//loop through the retrieved values
		{
			$row_set[] = $row['measurementName'];//build an array
		}
		echo json_encode($row_set);
?>