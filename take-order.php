<!DOCTYPE html>
<?php
	require "database/database.php";
	$db = new Database();
	$query = "SELECT * FROM menu";
	$query = $db->select($query);
	$row = $db->fetch($query);
?>
<html lang="en">
	<head>
		<title>Cafe Diem</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<script src="jquery/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/snackbar.css" />
		<link rel="stylesheet" href="css/material.css" />
		<script src=js/snackbar.min.js></script>
	</head>
	<nav class="navbar navbar-custom no-margin navbar-fixed-top">
		<div class="navbar-header">
			<a class="navbar-brand" href="orders.php"><img src="imgs/logo.png" class="pull-left"/><span><b>CAFE</b> DIEM</span></a>
		</div>
		<ul class="nav navbar-nav" style="margin-left: 145px; border-left: 1px solid rgba(256,256,256,0.5); border-right: 1px solid rgba(256,256,256,0.5);">
		<li class="active" ><a href="orders.php">View Orders</a><li>
		</ul>
		<ul class="nav navbar-nav" style="border-right: 1px solid rgba(256,256,256,0.5);">
			<li class="active"><a href="take-order.php">Take Orders</a><li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="logout-btn"><a href="updateIngredientsUsed.php" style="margin-right:14px;">Logout</a><li>
		</ul>
	</nav>
	<body onload="checkAvailableTable()">
	<div class="row content">
		<div id="sidebar-c" class="col-md-5">
		</div>

				<script>
					var Order = {};
					Order.subtotal = 0;
					Order.total = 0;
					Order.discount = 0;
					function orderEmpty() {
						$.post("orderEmpty.php", {}, function(data) {
							$("#sidebar-c").html(data);
							Order = {};
							Order.subtotal = 0;
							Order.total = 0;
							Order.discount = 0;
							liveSearch(1, "");
						});
					}
					
					function checkAvailableTable(){
						var tablenum = $("input#table").val();
						$.post("checkAvailableTable.php", {tablenum:tablenum}, function(data){
							if(data == "taken"){	
								$("input#table").val(parseInt(tablenum)+1);
								checkAvailableTable();
							}
							else if(data == "available"){
								var msg = {
									content: "Table "+tablenum+" is available!",
									style: "success"
								}
								$.snackbar(msg);
							}
							else if(data == "out of bounds"){
								$("input#table").val('');
								
								var msg = {
									content: "Table is unavailable!",
									style: "danger"
								}
								$.snackbar(msg);
							}
							else{
								
							}
						});
					}
					
					function add_menu(id) {
						name = "#mname_"+id;
						price = "#mprice_"+id;
						n = $(name).val();
						p = $(price).val();
						q = 1;
						t = parseInt(p) * q;
						order = "<tr><td class='col-md-3'>"+n+"</td><td class='col-md-2'><input type='number' id = 'qty_num' value='"+q+"' min='1' class='form-control' onchange='change_quantity(this)'/></td><td>Php "+parseInt(p).toFixed(2)+"</td><td>Php <span id='itemtotal'>"+t.toFixed(2)+"</span></td><td><a href='#'><button type='button' class='btn btn-danger' onclick='remove_order(this)'>x</button></a></td><input type='hidden' name='price' value='"+parseInt(p)+"' /><input type='hidden' name='quantity' value='"+q+"' /><input type='hidden' name='itemtotal' value='"+t+"'/><input type='hidden' name='itemID' value='"+id+"'/></tr>";

						if (Order.subtotal >= 1) {
							$("#order-list").append(order);
						} else {
							$("#order-list").html(order);
						}

						if (Order.subtotal < 1) {
							$("#confirm").removeClass("disabled");
						}

						update_total(t, "add");

						var menu = new Array();
						var orders = new Array();

						$("#order-list").find("tr").find("td:first-child").each(function () {
							var name = $(this).html();
							$("#menu-list").find("tbody").find("td[id='addBtn"+id+"']").parent().remove();
						});


					}

					function update_total(t, action) {
						if (action == "add") {
							Order.subtotal += t;
						} else {
							Order.subtotal -= t;
						}

						Order.total = Order.subtotal;
						if (Order.discount > 0) {
							var discount = Order.subtotal * (Order.discount/100);
							$("span#discount").html(discount);
							Order.total = Order.subtotal-discount;
						} else {
							$("span#discount").html(0);
						}
						$("#subtotal").html(Order.subtotal);
						$("#total").html(Order.total);
					}

					function remove_order(order) {
						var id = $(order).closest("tr").children("input[name^='itemID']").val();
						liveSearch(1,"");
						var price = $(order).closest("tr").children("input[name^='itemtotal']").val();
						update_total(price, "remove");

						if (Order.subtotal < 1) {
							$("#confirm").addClass("disabled");
						}

						$(order).closest("tr").remove();
						if ($("#order-list").children().length < 1) {
							$("#order-list").html('<tr><td colspan="5">No item added.</td></tr>');
						}
					}

					function change_quantity(order) {
						var prev_total = ($(order).closest("tr").children("input[name^='itemtotal']").val());
						var price = $(order).closest("tr").children("input[name^='price']").val();
						var qty = $(order).val();
						$(order).closest("tr").children("input[name^='quantity']").attr("value", qty);
						var menu_id = $(order).closest("tr").children("input[name^='itemID']").val();
						var total_due = Order.total;
						
						var new_price = price*qty;
						var added_price = (new_price)-prev_total;
						
						$(order).closest("tr").find("span#itemtotal").html(new_price.toFixed(2));
						update_total(added_price, "add");
					}

					function liveSearch(page,active) {
						var search = $("#searchbar").val();
						if (active == "") {
							var active = $("ul#tabs").children("li[class^='active']").attr("id");
						}
						$.post("menuSearch.php", {search:search, active:active, page:page}, function(data) {
							if (active == "all") {
								$("#home").find("tbody").html(data);
							} else if (active == "All-day") {
								$("#menu1").find("tbody").html(data);
							} else if (active == "Waffles") {
								$("#menu2").find("tbody").html(data);
							} else if (active == "Pizza") {
								$("#menu3").find("tbody").html(data);
							} else if (active == "Drinks") {
								$("#menu4").find("tbody").html(data);
							} else if (active == "Others") {
								$("#menu5").find("tbody").html(data);
							}

							var menu = new Array();
							var orders = new Array();

							$("#menu-list").find("tbody").find("input[id^='mname']").each(function () {
								menu.push($(this).val());
							});

							$("#order-list").find("tr").find("input[name^='itemID']").each(function () {
								var id = $(this).val();
								$("#menu-list").find("tbody").find("td[id='addBtn"+id+"']").parent().remove();
							});
						});
					}

/*					function checkIngredients(menuID, quantity) {
						$.ajaxSetup({async:false});
						var returnData = null;
						$.post("checkIngredients.php", {menuID:menuID, quantity:quantity}, function(data) {
							returnData = data;
						});
						$.ajaxSetup({async:true});
						return returnData;
					}	*/
					function confirmOrder() {
						var table = $("input#table").val();
						var qty = $("input#qty_num").val();
						if (table > 0 && !(table == '') && qty > 0){
						var total = $("span#total").text();
						$.post("addOrder.php", {table:table, total:total}, function(data) {
							var orderID = data;
							$("#order-list").find("tr").each(function(index, value) {
							var itemID = $(value).children("input[name^='itemID']").val();
							var qty = $(value).children("input[name^='quantity']").val();
								$.post("addOrderItem.php", {orderID:orderID, itemID:itemID, qty:qty}, function(data) {
									orderEmpty();
								});
							});
						});
						var options = {content:"Successfully added order!", style: "success"};
						$.snackbar(options);
						}else{
							var options = {content:"Cannot add order!", style: "danger"};
							$.snackbar(options);
						}
					}
				</script>
		<div id="wrapper" class="col-md-7">
			<div class="container-fluid">
				<h1 class="primary">Menu Items</h1>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="input-group">
							<input type="text" id="searchbar" class="form-control" placeholder="Search" onkeyup="liveSearch(1,'')"/>
							<span class="input-group-btn">
								<button class="btn btn-primary btn-search" type="button" onclick="liveSearch(1,'')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</span>
						</div>
					</div>
				</div>

				<ul id="tabs" class="nav nav-tabs pads-top">
					<li id="all" class="active"><a data-toggle="tab" href="#home" onclick='liveSearch(1, "all")'>All</a></li>
					<li id="All-day"><a data-toggle="tab" href="#menu1" onclick='liveSearch(1, "All-day")'>All-day Breakfast</a></li>
					<li id="Waffles"><a data-toggle="tab" href="#menu2" onclick='liveSearch(1, "Waffles")'>Waffles & Pancakes</a></li>
					<li id="Pizza"><a data-toggle="tab" href="#menu3" onclick='liveSearch(1, "Pizza")'>Pizza & Quesadillas</a></li>
					<li id="Drinks"><a data-toggle="tab" href="#menu4" onclick='liveSearch(1, "Drinks")'>Drinks</a></li>
					<li id="Others"><a data-toggle="tab" href="#menu5" onclick='liveSearch(1, "Others")'>Others</a></li>
				</ul>

				<div class="tab-content clearfix" id="menu-list">
					<div id="home" class="tab-pane fade in active">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-md-9">Menu Item</th>
									<th class="col-md-2">Price</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<script>liveSearch(1, "all")</script>
							</tbody>
						</table>
					</div>
					<div id="menu1" class="tab-pane fade">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-md-9">Menu Item</th>
									<th class="col-md-2">Price</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<script>liveSearch(1, "All-day")</script>
							</tbody>
						</table>
					</div>
					<div id="menu2" class="tab-pane fade">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-md-9">Menu Item</th>
									<th class="col-md-2">Price</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<script>liveSearch(1, "Waffles")</script>
						</table>
					</div>
					<div id="menu3" class="tab-pane fade">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-md-9">Menu Item</th>
									<th class="col-md-2">Price</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<script>liveSearch(1, "Pizza")</script>
							</tbody>
						</table>
					</div>
					<div id="menu4" class="tab-pane fade">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-md-9">Menu Item</th>
									<th class="col-md-2">Price</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<script>liveSearch(1, "Drinks")</script>
							</tbody>
						</table>
					</div>
					<div id="menu5" class="tab-pane fade">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-md-9">Menu Item</th>
									<th class="col-md-2">Price</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<script>liveSearch(1, "Others")</script>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div id="cancelModal" role="dialog" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							Cancelling order
						</div>
						<div class="modal-body text-center">
						<p>Are you sure you want to cancel?</p>
						<form method="post" action="orders.php">
						<input type="submit" class="btn btn-success" name="delete" value="Yes">
						<button type="button" class="btn btn-danger" data-dismiss="modal">No</button></form>
						</div>
					</div>
				</div>
			</div>

			<div id="discountModal" role="dialog" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							Add Discount
						</div>
						<div class="modal-body form-center text-center">
							<form action="#" method="post" role="form" class="form-inline">
								<div class="row">
									<div class="input-group col-md-9" style=" margin-top: 5px;">
										<span class="input-group-addon">
											Discount (%)
										</span>
										<input type="number" id="discount" class="form-control" placeholder="Discount" min="0">
									</div>
								</div>
								<button type="button" class="btn btn-success" onclick="addDiscount()" data-dismiss="modal" style="margin-top: 5px;">Add Discount</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: 5px;">Cancel</button>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">x</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>
	<script>orderEmpty();</script>
</html>
