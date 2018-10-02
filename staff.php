<?php
	session_start();
	require "database/database.php";
	$db = new Database();
	if(!isset($_SESSION['user'])){
		header("Location:../CDMIS/");
	} 
	$account_id = $_SESSION['account_id'];
	$account_name = $_SESSION['account_name'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />		
		<script src="jquery/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="jquery/jquery-ui.min.js"></script>
		<script src="script.js"></script>
		<script src="js/ajaxscripts.js"></script>
		<link rel="stylesheet" href="jquery/jquery-ui.min.css" />
		<link rel="stylesheet" href="css/style.css" />
		<script>
			function search(){
				value=$("#searchbox").val()
				$.post("adminIngredientSearch.php",{value:value},function(data){
					$("#searchbody").html(data);
				});
			}
			function liveSearch(page,active) {
				var search = $("#searchbar").val();
				if (active == "") {
					var active = $("ul#tabs").children("li[class^='active']").attr("id");
				}
				$.post("staffAjax.php", {search:search, active:active, page:page}, function(data) {
					if (active == "all") {
						$("#ingredients").find("tbody").html(data);
					}
					
				});
			}
					
		</script>
	</head>
	<nav class="navbar navbar-custom no-margin navbar-fixed-top">
	<div class="navbar-header">
		<a class="navbar-brand" href="overview.html"><img src="imgs/logo.png" class="pull-left"/><span><b>CAFE</b> DIEM</span></a>
	</div>
	<ul class="nav navbar-nav navbar-right">
			<li class="logout-btn"><a href="logout.php" style="margin-right:14px;">Logout</a><li>
	</ul>
	</nav>
	<body>
	<div class="row content">
		<div id="sidebar" class="col-md-3">
			<ul>
			<li>MANAGE</li>
				<ul>
					<li class="active"><a href="#">Ingredients<span class="active-img"></span></a></li>
					<li><a href="confirm-orders.php">Confirm Orders</a></li>
				</ul>
			</ul>
		</div>
		<div id="wrapper" class="col-md-9">
			<div class="container-fluid">
				<h1 class="primary">Ingredients</h1>
				<hr>
				<div class="row">
					<div class="col-md-10">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search" id="searchbox" onkeyup="search()"/>
							<span class="input-group-btn">
								<button class="btn btn-primary btn-search" type="button" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</span>
						</div>	
					</div>	
					<div class="col-md-2">
						<button type="button" class="btn btn-success form-control"  data-target="#addModal" data-toggle="modal">Add</button>
					</div>	
				</div>	

				<div class="panel panel-default pads-top text-left">
					<div class="panel-body" id="ingredients">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-md-7">Ingredient</th>
									<th>Qty</th> 
									<th>Action</th> 
								</tr>
							</thead>
							<tbody id="searchbody">
								<script>liveSearch(1, "all");</script>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<?php
			if(isset($_POST['editIngredients'])){
				$id = $_POST['ingredient_id'];
				$ingredient_name = $_POST['ingredient_name'];
				$quantity = $_POST['quantity'];
				$query = mysqli_query($con, "SELECT * FROM ingredients WHERE ingredient_id='$id'");
				mysqli_query($con, "UPDATE ingredients SET ingredient_name='$ingredient_name', ingredient_quantity='$quantity' WHERE ingredient_id='$id'");
				$affected = mysqli_affected_rows($con);
				if($affected==1){
					while($row = mysqli_fetch_assoc($query)){
						$logMsg = $account_name." edited quantity of ingredient: ".$ingredient_name. " from " . $row['ingredient_quantity'] . " to ". $quantity .".";
						mysqli_query($con, "INSERT INTO logs VALUES(0, '$logMsg', $account_id, NOW())");
					}

					echo "<script>alert('Ingredient has been edited successfully')</script>";
					printf("<script>location.href='staff.php'</script>");		
				}
				elseif ($affected == 0) {
					echo "<script>alert('No changes has been made.')</script>";
				}
				else{
					echo "<script>alert('There was an error edting the ingredient!')</script>";
				}
			}
		?>

		<div id="editModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Edit Ingredient
					</div>
					<div class="modal-body form-center text-center modal-edit">
						
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<?php
			if(isset($_POST['delete'])){
				$iID = $_POST['iID'];
				$query = mysqli_query($con, "SELECT * FROM ingredients WHERE ingredient_id='$iID'");
				mysqli_query($con, "DELETE FROM ingredients WHERE ingredient_id='$iID'");
				$affected = mysqli_affected_rows($con);
				if($affected==1){
					while($row = mysqli_fetch_assoc($query)){
						$ingredient = $row['ingredient_name'];
						$logMsg = $account_name . " deleted ingredient: " . $ingredient . ".";
						mysqli_query($con, "INSERT INTO logs VALUES(0, '$logMsg', $account_id, NOW())");
					}
					echo "<script>alert('Ingredient has been deleted successfully!')</script>";
					printf("<script>location.href='staff.php'</script>");		
				}
				else{
					echo "<script>alert('There was an error deleting the item!')</script>";
				}
			}
		?>

		<div id="deleteModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class='modal-header'>
						Deleting Ingredient
					</div>
					<div class='modal-body text-center modal-delete'>
					
					</div>
				</div>
			</div>
		</div>

		<?php
			if (isset($_POST['add_submit'])) {
				$ingredient_name = $_POST['ingredient_name'];
				$quantity = $_POST['quantity'];
				$measurement = $_POST['unit'];
				mysqli_query($con, "INSERT INTO ingredients VALUES (0, '$ingredient_name', '$quantity', '$measurement')");
				
				$affected = mysqli_affected_rows($con);
				if($affected==1){
					$logMsg = $account_name . " added ingredient: ".$ingredient_name.".";
					mysqli_query($con, "INSERT INTO logs VALUES(0, '$logMsg', $account_id, NOW())");

					echo "<script>alert('Ingredient has been added successfully!')</script>";
					printf("<script>location.href='staff.php'</script>");		
				}
				else{
					echo "<script>alert('There was an error in adding the ingredient!')</script>";
				}	
			}
		?>

		<div id="addModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<div class="modal-title">Add Ingredient</div>
					</div>
					<div class="modal-body form-center text-center">
						<form action="#" method="post" role="form" class="form-inline">
							<div class="row">
								<div class="input-group col-md-9" style=" margin-top: 5px;">
									<span class="input-group-addon">
										Ingredient Name
									</span>
									<input type="text" name="ingredient_name" id="ingredient" class="form-control" placeholder="Ingredient Name" pattern="[a-zA-Z]+" title="e.g. hotdog,egg" required>
								</div>
							</div> 
							<div class="row">
								<div class="input-group col-md-9" style=" margin-top: 5px;">
									<span class="input-group-addon">
										Qty
									</span>
									<input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity" min="1" required>
								</div>
							</div> 
							<div class="row">
								<div class="input-group col-md-9" style=" margin-top: 5px;">
									<span class="input-group-addon">
										Unit
									</span>
									<input type="text" name="unit" id="unit" class="form-control" placeholder="Unit" title="e.g. cup" pattern="[a-zA-Z0-9]{1,15}">
								</div>
							</div> 
							<button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: 5px;">Cancel</button>
							<input type="submit" name="add_submit" id="submit" class="form-control btn btn-success" style="margin-top: 5px;" value="Add">
						</form>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</div>
				</div>
			</div>
		</div>
	</div>
	</body>
</html>