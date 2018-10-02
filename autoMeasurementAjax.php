<?php
	require_once "database/database.php";
	$db = new Database();
	$ingredient = trim(strip_tags($_POST['ingredient']));//retrieve the search term that autocomplete sends
	$qstring = "SELECT measurement_name FROM ingredients, measurements WHERE ingredient_name = '".$ingredient."' AND ingredients.measurement_id = measurements.measurement_id";
	$result = $db->select($qstring);//query the database for entries containing the term

		while ($row = $db->fetch($result))//loop through the retrieved values
		{
         echo $row['measurement_name'];
		}
?>