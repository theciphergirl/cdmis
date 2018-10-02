<?php
	$con=mysqli_connect("localhost","root","","cdmis");

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql="SELECT * FROM account WHERE account_id='$id'";
		$result=mysqli_query($con,$sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$data = array(
			"account_id" => $row['account_id'],
			"account_name" => $row['account_name'],
			"account_type" => $row['access_type']
			);
		}
		echo json_encode($data, JSON_PRETTY_PRINT);
	}


?>