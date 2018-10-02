<?php
	session_start();
	require "database/database.php";
	$db = new Database();
	if(!isset($_SESSION['user'])){
		header("Location:../CDMIS/");
	} else if ($_SESSION['user_type'] != "3") {
		header("Location:../CDMIS/");
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Confirm Orders</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/style.css" />
		<script src="jquery/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/snackbar.css" />
		<link rel="stylesheet" href="css/material.css" />
		<script src=snackbar.min.js></script>
		<script>
			function confirm(orders_item_id){
				$.post("confirmOrdersAjax.php",{orders_item_id:orders_item_id},function(data){
						$("#confirm").html(data);
				});
			}
			
			function notify(){
				var options = {content:'There are no ingredients left for this order.', style: 'danger'};
				$.snackbar(options);
			}
			
			window.setInterval(function(){
				$.post("confirmOrdersReload.php", {category: "all-day-breakfast"}, function(data){
					$("#alldayreload").html(data);
				});
				$.post("confirmOrdersReload.php", {category: "waffles-pancakes"}, function(data){
					$("#wafflesreload").html(data);
				});
				$.post("confirmOrdersReload.php", {category: "drinks"}, function(data){
					$("#drinksreload").html(data);
				});
				$.post("confirmOrdersReload.php", {category: "pizza-quesadillas"}, function(data){
					$("#pizzareload").html(data);
				});
				
			}, 10000);
				
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
	<span id="confirm" style="display:none"></span>
	<?php
		$account_id = $_SESSION['account_id'];
		$account_name = $_SESSION['account_name'];
	?>
	<div class="row content">	
		<div id="sidebar" class="col-md-3">
			<ul>
			<li>MANAGE</li>
				<ul>
					<li><a href="staff.php">Ingredients</a></li>
					<li class="active"><a href="#">Confirm Orders</a><span class="active-img"></span></li>
				</ul>
			</ul>
		</div>
		<div id="wrapper" class="col-md-9">
			<div class="container-fluid">
				<h1 class="primary">Menu Items</h1>
				<hr>

				<ul class="nav nav-tabs pads-top">
					<li class="active"><a data-toggle="tab" href="#menu1">All-day Breakfast</a></li>
					<li><a data-toggle="tab" href="#menu2">Drinks</a></li>
					<li><a data-toggle="tab" href="#menu3">Pizzas & Quesadillas</a></li>
					<li><a data-toggle="tab" href="#menu4">Waffles & Pancakes</a></li>
				</ul>

				<div class="tab-content clearfix">
					<div id="menu1" class="tab-pane fade in active">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Table #</th>
									<th>Menu Name</th> 
									<th>Quantity</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id='alldayreload'>
								<?php
										$result=mysqli_query($con,"select * from orders_item join orders join menu where orders.order_id=orders_item.order_id and menu.menu_id=orders_item.menu_id 
																   and confirmation_status=0 and category='all-day-breakfast'");
										if(mysqli_affected_rows($con)==0){
											echo "<tr><td>No items to show.</td></tr>";
										}
										else{
											while($row=mysqli_fetch_assoc($result)){
												$orders_item_id=$row['orders_item_id'];	
												echo '<tr>
														<td>'.$row['table_number'].'</td>
														<td>'.$row['menu_name'].'</td>
														<td>'.$row['order_quantity'].'</td>
														<td><button class="btn btn-success" onclick="confirm('.$orders_item_id.')">Confirm</button></td>
													  </tr>';
											}
										}
									?>
							</tbody>
						</table>
					</div>
					<div id="menu2" class="tab-pane fade">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Table #</th>
									<th>Menu Name</th> 
									<th>Quantity</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id='drinksreload'>
								<?php
										$result=mysqli_query($con,"select * from orders_item join orders join menu where orders.order_id=orders_item.order_id and menu.menu_id=orders_item.menu_id 
																   and confirmation_status=0 and category='drinks'");
										if(mysqli_affected_rows($con)==0){
											echo "<tr><td>No items to show.</td></tr>";
										}
										else{
											while($row=mysqli_fetch_assoc($result)){
													
												$orders_item_id=$row['orders_item_id'];	
												echo '<tr>
														<td>'.$row['table_number'].'</td>
														<td>'.$row['menu_name'].'</td>
														<td>'.$row['order_quantity'].'</td>
														<td><button class="btn btn-success" onclick="confirm('.$orders_item_id.')">Confirm</button></td>
													  </tr>';
											}
										}
									?>
							</tbody>
						</table>
					</div>
					<div id="menu3" class="tab-pane fade">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Table #</th>
									<th>Menu Name</th> 
									<th>Quantity</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id='pizzareload'>
								<?php
										$result=mysqli_query($con,"select * from orders_item join orders join menu where orders.order_id=orders_item.order_id and menu.menu_id=orders_item.menu_id 
																   and confirmation_status=0 and category='pizza-quesadillas'");
										if(mysqli_affected_rows($con)==0){
											echo "<tr><td>No items to show.</td></tr>";
										}
										else{
											while($row=mysqli_fetch_assoc($result)){												
												$orders_item_id=$row['orders_item_id'];	
												echo '<tr>
														<td>'.$row['table_number'].'</td>
														<td>'.$row['menu_name'].'</td>
														<td>'.$row['order_quantity'].'</td>
														<td><button class="btn btn-success" onclick="confirm('.$orders_item_id.')">Confirm</button></td>
													  </tr>';
											}
										}
									?>
							</tbody>
						</table>
					</div>
					<div id="menu4" class="tab-pane fade">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Table #</th>
									<th>Menu Name</th> 
									<th>Quantity</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id='wafflesreload'>
								<?php
										$result=mysqli_query($con,"select * from orders_item join orders join menu where orders.order_id=orders_item.order_id and menu.menu_id=orders_item.menu_id 
																   and confirmation_status=0 and category='waffles-pancakes'");
										if(mysqli_affected_rows($con)==0){
											echo "<tr><td>No items to show.</td></tr>";
										}
										else{
											while($row=mysqli_fetch_assoc($result)){
													
												$orders_item_id=$row['orders_item_id'];	
												echo '<tr>
														<td>'.$row['table_number'].'</td>
														<td>'.$row['menu_name'].'</td>
														<td>'.$row['order_quantity'].'</td>
														<td><button class="btn btn-success" onclick="confirm('.$orders_item_id.')">Confirm</button></td>
													  </tr>';
											}
										}
									?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<div id="editModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Editing 'name here'
					</div>
					<div class="modal-body form-center text-center">
						<form action="#" method="post" role="form" class="form-inline">
							<div class="row">
									<div class="input-group col-md-6">
										<span class="input-group-addon">
											Ingredient
										</span>
										<input type="text" id="ingredient" class="form-control" placeholder="Ingredient name">	
									</div>
									<div class="input-group col-md-3">
										<span class="input-group-addon">
											Qty
										</span>
										<input type="text" id="ingredient" class="form-control" placeholder="Quantity">
									</div>
									
										
									<button type="button" class="btn btn-success">+</button>
							</div>
							<div class="row">
									<div class="input-group col-md-10" style=" margin-top: 5px;">
										<span class="input-group-addon">
											Price
										</span>
										<input type="text" id="ingredient" class="form-control" placeholder="Price">
									</div>
							</div> 
							<button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: 5px;">Cancel</button>
							<input type="submit" id="submit" class="form-control btn btn-success" style="margin-top: 5px;" value="Save Changes">
						</form>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="deleteModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Deleting 'name here'
					</div>
					<div class="modal-body text-center">
					<p>Are you sure you want to delete _______ ?</p>
					<form method="post" action="#"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<input type="submit" class="btn btn-success" name="delete" value="Delete"></form>
					</div>
				</div>
			</div>
		</div>
		
		<div id="viewModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Viewing 'name here'
					</div>
					<div class="modal-body">
					<div class="list-group">
						<a href="#" class="list-group-item">
							<h3 class="list-group-item-heading">Ingredients</h3>
							<div class="container-fluid">
								<p class="list-group-item-text"><b>1 cup</b> something</p>
								<p class="list-group-item-text"><b>12 lbs</b> something</p>
								<p class="list-group-item-text"><b>3 tbsp</b> something</p>
							</div>
						</a>
						<a href="#" class="list-group-item">
							<h3 class="list-group-item-heading">Price</h3>
							<div class="container-fluid">
								<p class="list-group-item-text"><b>Php 999.99</b></p>
							</div>
						</a>
					</div>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="addModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Adding new menu item
					</div>
					<div class="modal-body form-center text-center">
						<form action="#" method="post" role="form" class="form-inline">
							<div class="row">
									<div class="input-group col-md-10" style=" margin-bottom: 5px;">
										<span class="input-group-addon">
											Menu Item
										</span>
										<input type="text" id="ingredient" class="form-control" placeholder="Menu Item">
									</div>
							</div> 
							<div class="row">
									<div class="input-group col-md-6">
										<span class="input-group-addon">
											Ingredient
										</span>
										<input type="text" id="ingredient" class="form-control" placeholder="Ingredient name">	
									</div>
									<div class="input-group col-md-3">
										<span class="input-group-addon">
											Qty
										</span>
										<input type="text" id="ingredient" class="form-control" placeholder="Quantity">
									</div>
									
										
									<button type="button" class="btn btn-success">+</button>
							</div>
							<div class="row">
									<div class="input-group col-md-10" style=" margin-top: 5px;">
										<span class="input-group-addon">
											Price
										</span>
										<input type="text" id="ingredient" class="form-control" placeholder="Price">
									</div>
							</div> 
							<button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: 5px;">Cancel</button>
							<input type="submit" id="submit" class="form-control btn btn-success" style="margin-top: 5px;" value="Add">
						</form>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>
</html>