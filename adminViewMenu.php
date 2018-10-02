<a href="#" class="list-group-item">
	<h3 class="list-group-item-heading">Ingredients</h3>
	<div class="container-fluid">
		<?php
			require_once "database/database.php";
			$db = new Database();
			$menu_id=$_POST['id'];
			$ingredients_result=$db->select("select * from recipe join ingredients join measurements where ingredients.measurement_id=measurements.measurement_id and menu_id='$menu_id' and recipe.ingredient_id=ingredients.ingredient_id");
			while($row=$db->fetch($ingredients_result)){
				$recipe_quantity=$row['recipe_quantity'];
				$measurement=$row['measurement_name'];
				$ingredient_name=$row['ingredient_name'];
				echo '<p class="list-group-item-text"><b>'.$recipe_quantity.' '.$measurement.'</b>  '.$ingredient_name.'</p>';
			}
		?>
	</div>
</a>
<a href="#" class="list-group-item">
	<h3 class="list-group-item-heading">Price</h3>
	<div class="container-fluid">
		<?php
			$price_result=$db->select("select price from menu where menu_id='$menu_id'");
			$row=$db->fetch($price_result);
			echo '<p class="list-group-item-text"><b>Php '.$row['price'].'</b></p>';
		?>
		
	</div>
</a>
