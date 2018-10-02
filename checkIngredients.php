<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$menuID = $_POST['menuID'];
	$qty = $_POST['quantity'];

$query = "select * from(select menu.menu_id,menu_name,price,ingredient_quantity,recipe_quantity,count(menu.menu_id) as count1 from menu join
				recipe join ingredients where menu.menu_id=recipe.menu_id and recipe.ingredient_id=ingredients.ingredient_id and
				ingredient_quantity>=(recipe_quantity * '$qty')	 and menu.menu_id = '$menuID' group by menu_id) alias join (select count(menu_id) as count1,menu_id from recipe group by menu_id)alias2
				where alias.menu_id=alias2.menu_id and alias.count1=alias2.count1 ORDER by menu_name";

	$query = $db->select($query);
	if ($db->affected() > 0) {
		echo "true";
	} else {
		echo "false";
	}
?>
