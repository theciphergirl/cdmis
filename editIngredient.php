<?php
	require_once "database/database.php";
	$db = new Database();

	if( ($_POST['id'])){
		$id = $_POST['id'];
		
		$sql="SELECT * FROM ingredients JOIN measurements WHERE ingredients.ingredient_id='$id' and measurements.measurement_id=ingredients.measurement_id";
		$result=$db->select($sql);
		while ($row = $db->fetch($result)) {
		
			echo "<form action='#' method='post' role='form' class='form-inline'>
					<div class='row'>
						<div class='input-group col-md-9' style=' margin-top: 5px;'>
							
							<span>". $row["ingredient_name"] ."</span>
							<input type='hidden' name='ingredient_id' id='ingredient_id' value='".$row["ingredient_id"]."'/>
							<input type='hidden' name='ingredient_name' id='ingredient_name' value='".$row["ingredient_name"]."'/>
						</div>
					</div> 
					<div class='row'>
						<div class='input-group col-md-5' style=' margin-top: 5px;'>
							<span class='input-group-addon'>
								Qty
							</span>
							<input type='number' id='quantity' name='quantity' class='form-control' value='". $row["ingredient_quantity"] ."' min='1' required>
							
						</div><span style='padding-left:8px'>".$row['measurement_name']."</span>
					</div> 
					<button type='button' class='btn btn-danger' data-dismiss='modal' style='margin-top: 5px;'>Cancel</button>
					<input type='submit' id='submit' name='editIngredients' class='form-control btn btn-success' style='margin-top: 5px;' value='Save Changes'>
				</form>";
				
				
		}
	}


?>