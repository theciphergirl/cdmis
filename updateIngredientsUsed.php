<?php
	session_start();
	require_once "database/database.php";
	$db = new Database();
	$account_name = $_SESSION['account_name'];
	$account_id = $_SESSION['account_id'];
	$ing = $db->select("SELECT ingredient_id, ingredient_name, measurements.measurement_name FROM ingredients, measurements WHERE measurements.measurement_id = ingredients.measurement_id");
	if($db->affected() > 0){
		while($ingredient = $db->fetch($ing)){
			$ing_id = $ingredient['ingredient_id'];
			$ing_name = $ingredient['ingredient_name'];
			$ing_msr = $ingredient['measurement_name'];
			$qu = $db->select("SELECT SUM(recipe.recipe_quantity*orders_item.order_quantity) as quantity FROM orders, orders_item, recipe, ingredients
				WHERE orders.order_id=orders_item.order_id AND recipe.menu_id=orders_item.menu_id AND ingredients.ingredient_id=recipe.ingredient_id AND orders.status='Paid'
				AND month(orders.order_date)=month(CURDATE()) AND year(orders.order_date)=year(CURDATE()) AND ingredients.ingredient_id='$ing_id' ORDER BY ingredients.ingredient_id, orders.order_id");
			if($db->affected() > 0){
				$qty=$db->fetch($qu);
				if($qty['quantity'] > 0){
					$used_qty = $qty['quantity'];
					echo $ing_name.": ".$qty['quantity']." ".$ing_msr."<br/>";
					$db->query("UPDATE ingredients SET ingredient_quantity = $used_qty WHERE ingredient_id = $ing_id");
				}
			}
		}
	}
	header("Location: logout.php");
?>