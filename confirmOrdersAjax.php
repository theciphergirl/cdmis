<?php
	$con=mysqli_connect("localhost","root","","cdmis");
	$account_name = $_SESSION['account_name'];
	$account_id = $_SESSION['account_id'];
	$orders_item_id=$_POST['orders_item_id'];
	$query="SELECT * FROM recipe join ingredients join orders_item where orders_item.orders_item_id=$orders_item_id and
			recipe.menu_id=orders_item.menu_id and ingredients.ingredient_id=recipe.ingredient_id";
	$result=mysqli_query($con,$query);
	$num_rows=mysqli_affected_rows($con);
	$count=0;
	while($row=mysqli_fetch_assoc($result)){
		if($row['recipe_quantity']<=$row['ingredient_quantity']){
			$count+=1;
		}
	}

	if($count==$num_rows and $num_rows!=0){
		$result=mysqli_query($con,$query);
		while($row=mysqli_fetch_assoc($result)){
			$recipe_quantity=$row['recipe_quantity'];
			$ingredient_quantity=$row['ingredient_quantity'];
			$ingredient_quantity-=$recipe_quantity;
			$ingredient_id=$row['ingredient_id'];
			mysqli_query($con,"update ingredients set ingredient_quantity=$ingredient_quantity WHERE ingredient_id='$ingredient_id'");
			mysqli_query($con,"update orders_item set confirmation_status=1 where orders_item_id=$orders_item_id");

			$logMsg = $account_name."confirmed order of menu item: ".$row['ingredient_name'].".";
			mysqli_query($con, "INSERT INTO logs VALUES(0, '$logMsg', $account_id, NOW())");

			echo "<script>location.reload()</script>";

		}
	}
	else{
		echo "<script>notify()</script>";
	}
?>
