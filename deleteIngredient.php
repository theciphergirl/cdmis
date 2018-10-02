<?php
	$con=mysqli_connect("localhost","root","","cdmis");
	
	if(isset($_POST['iID'])){
		$iID = $_POST['iID'];
		$sql="SELECT * FROM ingredients WHERE ingredient_id='$iID'";
		$result=mysqli_query($con,$sql);
		while ($row = mysqli_fetch_row($result)) {
			$name = $row[1];
			$id= $row[0];
			echo "<p>Are you sure you want to delete <b><i>". $name ."</i></b> ?</p>
					<form method='post' action='#''><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
					<input type='hidden' name='iID' id='iID' value='".$id."'/>
					<input type='submit' class='btn btn-success' name='delete' value='Delete'></form>";
		}
	}

?>

<!--<input type='submit' class='btn btn-success' name='delete' value='Delete'>
<a class="btn btn-success" href="deleteIngredient.php?iID='. $id .'" role="button">Delete</a>-->