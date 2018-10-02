<?php
	require_once "database/database.php";
	$db = new Database();
	$item = $_POST['item'];//retrieve the search term that autocomplete sends
	$qstring = "SELECT * FROM menu WHERE menu_id = ".$item."";
	$result = $db->select($qstring);//query the database for entries containing the term
	$info = Array();
	
		while ($row = $db->fetch($result))//loop through the retrieved values
		{
			foreach($row as $component){
				if($component == $row['menu_id']){
					$itemnum = $component;
				}
				array_push($info, $component);
			}
		}
		
	$rstring = "SELECT * FROM recipe WHERE menu_id = '".$itemnum."'";
	$result = $db->select($rstring);//query the database for entries containing the term
	$comps = Array();
	
		while ($row = $db->fetch($result))//loop through the retrieved values
		{
			$istring = "SELECT * FROM ingredients WHERE ingredient_id = ".$row['ingredient_id']."";
			$result2 = $db->select($istring);//query the database for entries containing the term
			while($row2 = $db->fetch($result2)){
				$mID = $row2['measurement_id'];
				$mstring = "SELECT * FROM measurements WHERE measurement_id = $mID";
				$resultm = $db->select($mstring);
				if($rowm = $db->fetch($resultm)){
				$temp = [$row2['ingredient_name'], $row['recipe_quantity'], $rowm['measurement_name']];
				}
				array_push($comps, $temp);
			}
		}
		
		array_push($info, $comps);
		
		echo json_encode($info);
?>