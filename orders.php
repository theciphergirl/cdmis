<?php
	session_start();
	require "database/database.php";
	$db = new Database();
	$account_id = $_SESSION['account_id'];
	$account_name = $_SESSION['account_name'];
?>
<?php
	if(isset($_POST['edit_order'])){
		$order_id=$_POST['order_id'];
		$table_number=$_POST['table_number'];
		$order_quantity=$_POST['order_quantity'];
		$price=$_POST['price'];
		$bill=$_POST['bill'];
		$db->query("UPDATE orders AS o INNER JOIN orders_item AS oi INNER JOIN menu as m ON o.order_id = $order_id AND oi.order_id = o.order_id AND m.menu_id = oi.menu_id SET o.table_number = $table_number AND oi.orders_item = $orders_item AND m.price = $price AND o.bill = $bill");
		if ($db->affected() > 0){
			$logMsg = "updated order of table: " . $table_number .".";
			mysqli_query($con, "INSERT INTO logs VALUES(0, '$logMsg', $account_id, NOW())");

			echo "<script>alert('Item updated successfully')</script>";
		}
		else{
			echo "There was an error";
		}

		header("Location:orders.php");
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Cafe Diem Order</title>
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
		<script>

			function openOrder(order_id){
				$.post("orderAjax.php",{order_id:order_id},function(data){
					$("#sidebar-c").html(data)
				  	Order.subtotal = $("span#subtotal").html();
				  	Order.discount = $("span#discount").html();
				  	Order.total = $("span#total").html();
				});
			}
			
			function Add(order_id){
				$.post("payAjax.php",{order_id:order_id},function(data){
					$("#sidebar-c").html(data)
				});
			}

        	function Pay(order_id){
				$('input[name^="payBtn"]').attr("value",order_id);
				$('#payModal').modal('show');
			}

			function payOrder() {
				var orderID = $('input[name^="payBtn"]').val();
				$.post("payAjax.php", {id:orderID}, function(data){
					if(data == "success"){
						var options = {
							content: "Order successfully paid!",
							style: "success"
						}
						$.snackbar(options);
						openOrder(orderID);
					}
				});
				liveSearch2(1, '');
				$.post("updateFrequency.php", {id:orderID}, function(data){
					location.reload();
				});
			}

	/*		function pay_individual_order(orders_item_id,order_id,menu_name,order_quantity,price){
				 // $('input[name^="payIndivBtn"]').attr("value",order_id);
					var total=price*order_quantity;
					$("#menuName").html(menu_name);
					$("#qtyID").val(order_quantity);
					$("#qtyID").attr("max",order_quantity);
					$("#priceID").html(price);
					$("#totalID").html(total);
					$("#total_id").val(total);
					$('#payIndivModal').modal('show');
					$("#order_id").val(order_id);
					$("#orders_item_id").val(orders_item_id);

				//alert(order_id);

			}	*/
			function Cancel_Order(order_id){
				$('input[name^="cancelBtn"]').attr("value",order_id);
				$('#cancelModal').modal('show');
			}
			
			function remove_order(orders_item_id,order_id,menu_name,order_quantity,price,e){
				update_total(price,'subtract');
				$("#order-list").find("tr").each(function(index, value) {
					var total = Order.subtotal;
					var qty = $(value).children("input[name^='quantity']").val();
					
					$.post("deleteOrderItem.php", {order_id:order_id, orders_item_id:orders_item_id, qty:qty, total:total}, function(data) {
						if(data == "delete"){
							location.reload();
						}else if(data != ""){
							openOrder(order_id);
							liveSearch2(1, "");
							var options = {content:"Successfully delete order!", style: "success"};
						}
						else{
							var options = {content:"Could not delete order!", style: "success"};
						}
					});
				});
				$.snackbar(options);
				e.closest("tr").remove();
			}

			function liveSearch(page, active) {
				var search = $("#searchbar").val();
				if (active == "") {
					var active = $("ul#tabs").children("li[class^='active']").attr("id");
				}
				$.post("menuSearch.php", {page:page, search:search, active:active}, function(data) {
					if (active == "all") {
						$("#home_menu").find("tbody").html(data);
					} else if (active == "All-day") {
						$("#menu_1").find("tbody").html(data);
					} else if (active == "Waffles") {
						$("#menu_2").find("tbody").html(data);
					} else if (active == "Pizza") {
						$("#menu_3").find("tbody").html(data);
					} else if (active == "Drinks") {
						$("#menu_4").find("tbody").html(data);
					} else if (active == "Others") {
						$("#menu_5").find("tbody").html(data);
					}

					$("#order-list").find("tr").each(function() {
						var name = $(this).find("td:first-child").html();
						var orderID = $(this).find("td:first-child").siblings("input[name='menu-id']").val();
						if (orderID == undefined) {
							var orderID = $(this).find("td:first-child").siblings("input[name='itemID']").val();
						}
						$("#menu-list").find("tbody").find("td[id='addBtn"+orderID+"']").parent().remove();
					});
				});
			}

			function liveSearch2(page, active) {
				if (active == "") {
					var active = $("ul#tabs").children("li[class^='active']").attr("id");
				}
				$.post("ordersSearch.php", {page:page, active:active}, function(data) {
					if (active == "all") {
						$("#home").find("tbody").html(data);
					} else if (active == "paid") {
						$("#menu1").find("tbody").html(data);
					} else if (active == "not-paid"){
						$("#menu2").find("tbody").html(data);
					}
				});
			}

			function changeTotal(qty){
				$qty=$("#qtyID").val();
				$price=$("#priceID").html();
				$("#totalID").html($price*$qty);
				$("#total_id").val($price*$qty)
			}

			var Order = {};
					Order.subtotal =0;
					Order.total = 0;
					Order.discount = 0;
					Order.id = 0;

					function add_menu(id) {

						$('#confirm').show();
						
						name = "#mname_"+id;
						price = "#mprice_"+id;

						n = $(name).val();
						p = $(price).val();

						q = 1;
						t = parseInt(p) * q;

						order = "<tr id="+id+"><td class='col-md-3'>"+n+"</td><td class='col-md-2'><input type='number' value='"+q+"' min='1' class='form-control' onchange='change_quantity(this)'/></td><td>Php "+parseInt(p).toFixed(2)+"</td><td><span id='itemtotal'>Php "+t.toFixed(2)+"</span></td><td><a href='#'><button type='button' class='btn btn-danger' onclick='remove_individually(this)'>x</button></a></td><input type='hidden' name='price' value='"+parseInt(p)+"' /><input type='hidden' name='quantity' value='"+q+"' /><input type='hidden' name='itemtotal' value='"+t+"'/><input type='hidden' name='itemID' value='"+id+"'/></tr>";

						$("#order-list").append(order);

						if (Order.subtotal < 1) {
							$("#confirm").toggleClass("disabled");
						}

						update_total(t, "add");

						$("#order-list").find("tr").find("td:first-child").each(function () {
							var name = $(this).html();
							$("#menu-list").find("tbody").find("td[id='addBtn"+id+"']").parent().remove();
						})
					}

					function update_total(t, action) {
						Order.subtotal = parseInt(Order.subtotal);
						t = parseInt(t);
						if (action == "add") {
							Order.subtotal += t;
						} else {
							Order.subtotal -= t;
						}
						if (Order.discount > 0) {
							$("span#discount").html(Order.discount);
							Order.total = Order.subtotal-(Order.subtotal * (Order.discount/100));
						} else {
							$("span#discount").html(0);
							Order.total = Order.subtotal;
						}
						$("span#subtotal").html((Order.subtotal).toFixed(2));
						$("span#total").html((Order.total).toFixed(2));
					}
					function remove_individually(e){

						e.closest('tr').remove();
						if($(".orderRemove").length == 1){
							var add = $(".orderRemove").first();
							add.addClass("disabled");
						//	add.off("click");
						}
					}

					function placeOrderID(order){
						var ord = $("input#order_id").val(order);
						Order.id = order;
					}
					
					function addDiscount() {
						var discount = $("input#discount").val();
						var orderID = Order.id;
						var subtotal = parseFloat($("span#subtotal").html()).toFixed(2);
						if (discount > 0) {
							$("button#discount").html("Change Discount");
							$("button#discount_btn").html("Change Discount");
						} else {
							$("button#discount").html("Add Discount");
							$("button#discount_btn").html("Add Discount");
						}
						
						$.post("updateDiscount.php", {orderID:orderID,discount:discount}, function(data) {
							if(data != "error"){
								var less = (subtotal*(discount/100));
								total = subtotal-less;
								Order.discount = discount;
								//Order.subtotal = subtotal;
								$('span#discount').html(discount);
								$('span#total').html(total.toFixed(2));
							}
						});
						
					}
					
					function change_quantity(order) {
						var prev_total = ($(order).closest("tr").children("input[name^='itemtotal']").val());
						var price = $(order).closest("tr").children("input[name^='price']").val();
						var qty = $(order).val();
						$(order).closest("tr").children("input[name^='quantity']").val();
						var new_total = price * qty;
						update_total(prev_total, "remove");
						update_total(new_total, "add");
						$(order).closest("tr").children("input[name^='itemtotal']").attr("value", new_total);
						$(order).closest("tr").find("span[name^='itemtotal']").html((new_total).toFixed(2));
					}

					function confirmOrder(orderID) {
						total = 0;
						$("#order-list").find("tr").each(function(index, value) {
						var itemID = $(value).children("input[name^='itemID']").val();
						var qty = $(value).children("input[name^='quantity']").val();
						var itemtotal = $(value).children("input[name^='itemtotal']").val();
						total += parseInt(itemtotal);

						$.post("addOrderItem.php", {orderID:orderID, itemID:itemID, qty:qty}, function(data) {
							});
						});	

						$.post("addOrderItem.php", {orderID:orderID, total:total}, function(data) {
							openOrder(orderID);
							liveSearch2(1, "");
							});
						var options = {content:"Successfully added order!", style: "success"};
						$.snackbar(options);
					}
				</script>
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
	<body>
	<span id='hiddenSpan' style='display:none'></span>
	<div class="row content">
		<div id="sidebar-c" class="col-md-5 text-center">
		</div>
	</div>
	
	<div id="addingModal" role="dialog" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				Add Menu
				<button type="button" class="btn btn-default" data-dismiss="modal" style="float: right;margin-top: -9%;">x</button>
				</div>
				<div class="modal-body form-center text-center" id="menu-list">
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
									<input type="text" id="searchbar" class="form-control" placeholder="Search" onkeyup="liveSearch(1,'')"/>
									<span class="input-group-btn">
										<button class="btn btn-primary btn-search" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
									</span>
								</div>
							</div>
						</div>

							<ul id="tabs" class="nav nav-tabs pads-top">
								<li id="all" class="active"><a data-toggle="tab" href="#home_menu" onclick='liveSearch(1, "all")'>All</a></li>
								<li id="All-day"><a data-toggle="tab" href="#menu_1" onclick='liveSearch(1, "All-day")'>All-day Breakfast</a></li>
								<li id="Waffles"><a data-toggle="tab" href="#menu_2" onclick='liveSearch(1, "Waffles")'>Waffles & Pancakes</a></li>
								<li id="Pizza"><a data-toggle="tab" href="#menu_3" onclick='liveSearch(1, "Pizza")'>Pizza & Quesadillas</a></li>
								<li id="Drinks"><a data-toggle="tab" href="#menu_4" onclick='liveSearch(1, "Drinks")'>Drinks</a></li>
								<li id="Others"><a data-toggle="tab" href="#menu_5" onclick='liveSearch(1, "Others")'>Others</a></li>
							</ul>
							<div class="tab-content clearfix">
								<div id="home_menu" class="tab-pane fade in active">
									<table class="table table-striped">
										<thead>
											<tr>
												<th class="col-md-9">Menu Item</th>
												<th class="col-md-2">Price</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody class='text-left'>
											<script>liveSearch(1, "all")</script>
										</tbody>
									</table>
								</div>
								<div id="menu_1" class="tab-pane fade">
									<table class="table table-striped">
										<thead>
											<tr>
												<th class="col-md-9">Menu Item</th>
												<th class="col-md-2">Price</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody class='text-left'>
												<script>liveSearch(1, "All-day")</script>
										</tbody>
									</table>
								</div>
								<div id="menu_2" class="tab-pane fade">
									<table class="table table-striped">
										<thead>
											<tr>
												<th class="col-md-9">Menu Item</th>
												<th class="col-md-2">Price</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody class='text-left'>
												<script>liveSearch(1, "Waffles")</script>
									</table>
								</div>
								<div id="menu_3" class="tab-pane fade">
									<table class="table table-striped">
										<thead>
											<tr>
												<th class="col-md-9">Menu Item</th>
												<th class="col-md-2">Price</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody class='text-left'>
												<script>liveSearch(1, "Pizza")</script>
										</tbody>
									</table>
								</div>
								<div id="menu_4" class="tab-pane fade">
									<table class="table table-striped">
										<thead>
											<tr>
												<th class="col-md-9">Menu Item</th>
												<th class="col-md-2">Price</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody class='text-left'>
												<script>liveSearch(1, "Drinks")</script>
										</tbody>
									</table>
								</div>
								<div id="menu_5" class="tab-pane fade">
									<table class="table table-striped">
										<thead>
											<tr>
												<th class="col-md-9">Menu Item</th>
												<th class="col-md-2">Price</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody class='text-left'>
												<script>liveSearch(1, "Others")</script>
										</tbody>
									</table>
								</div>
							</div>
							</div>
						</div>
				</div>
			<!-- </div> -->
		<!-- </div> -->
	</div>

	<div id="wrapper" class="col-md-7">
		<div class="container-fluid">
			<h1 class="primary">View Orders</h1>
			<hr>
			<div class="row">
				<div class="col-md-10">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Search" />
						<span class="input-group-btn">
							<button class="btn btn-primary btn-search" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
						</span>
					</div>
				</div>

				<div class="col-md-2">
					<a href="take-order.php"><button type="button" class="btn btn-success form-control">Add</button></a>
				</div>
			</div>

			<ul class="nav nav-tabs pads-top">
				<li id="all"  onclick="liveSearch2(1, 'all')"><a data-toggle="tab" href="#home" onclick='liveSearch2(1, "all")'>All</a></li>
				<li id="paid" onclick="liveSearch2(1, 'paid')"><a data-toggle="tab" href="#menu1" onclick='liveSearch2(1, "paid")'>Paid</a></li>
				<li id="not-paid" class="active" onclick="liveSearch2(1, 'not-paid')"><a data-toggle="tab" href="#menu2" onclick='liveSearch2(1, "not-paid")'>Not paid</a></li>
			</ul>

			<div class="tab-content clearfix">
				<div id="home" class="tab-pane fade">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Table #</th>
								<th>Payment Status</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<script>liveSearch2(1, "all")</script>
						</tbody>
					</table>
				</div>
				<div id="menu1" class="tab-pane fade">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Table #</th>
								<th>Payment Status</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<script>liveSearch2(1, "paid")</script>
						</tbody>
					</table>
				</div>
				<div id="menu2" class="tab-pane fade in active">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Table #</th>
								<th>Payment Status</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<script>liveSearch2(1, "not-paid")</script>
						</tbody>
					</table>
				</div>
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
				<form method="get" action="cancelOrderAjax.php">
				<input type="hidden" name="cancelBtn" value="">
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
									<span id="hidden" style="display:none"></span>
									<input type="number" id="discount" class="form-control" placeholder="Discount" min="0">
									<input type="hidden" id="order_number">
								</div>
							</div>
							<button type="button" id="discount_btn" class="btn btn-success" onclick="addDiscount()" data-dismiss="modal" style="margin-top: 5px;">Add Discount</button>
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


		<div id="payModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Pay Order
					</div>
					<div class="modal-body text-center">
					<p>Are you sure you want to pay your order?</p>
 					<input type="hidden" name="payBtn" value="">
					<button type="submit" class="btn btn-success" data-dismiss="modal" onclick="payOrder()">Yes</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">No</button></form>
					</div>
				</div>
			</div>
		</div>

		<div id="payIndivModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Pay Order
					</div>
					<div class="modal-body text-center">
					<table class="table table-responsive">
					<form method="get" action="payIndividuallyAjax.php">
					<tr><th></th><th>Qty</th><th>Price</th><th>Total</th><th></th><th></th></tr>
					<tr>
						<td><span id="menuName"></span></td>
						<td><input type='number' name='qtyID' id='qtyID' min='1' onchange='changeTotal()'></td>
						<td><span id="priceID"></span></td>
						<td><span id="totalID"></span></td>

					<td>
 					<input type="hidden" id="order_id" name="order_id">
 					<input type="hidden" id="orders_item_id" name="orders_item_id">
					<input type="hidden" id="total_id" name="total_id">
					<input type="submit" class="btn btn-success" name="payIndiv" value="Pay"></td>
					<td><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></td></tr></form></table>

					</div>
				</div>
			</div>
		</div>
	</div>
	</body>
</html>
