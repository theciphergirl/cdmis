<?php
	session_start();
	require "database/database.php";
	$db = new Database();
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
		<link rel="stylesheet" href="jquery/jquery-ui.min.css" />
		<link rel="stylesheet" href="css/style.css" />
		<script>
			function addMoreButton(){
            var index = ($(".ingredient").length)+1;
				$("#ingredient_row").append('<div id="parentDiv"><div class="ing-group input-group col-md-5" style="margin-right:5px"><span class="input-group-addon">Ingredient</span><input type="text" id="ingredient" name="ingredient[]" onkeyup="completeMeasurement(this)" class="form-control ingredient" placeholder="Ingredient name" autocomplete="off"></div><div class="input-group col-md-2" style="margin-right:5px"><input type="number" id="ingredient_quantity" name="ingredient_quantity[]" class="form-control" placeholder="Quantity" min="0.25" step="0.25" required></div><div class="input-group col-md-2" style="margin-right:5px"><input type="text" id="ingredient_measurement'+index+'" name="ingredient_measurement[]" class="form-control measurement" placeholder="e.g. pc, cup, etc."></div><button type="button" class="btn btn-danger addRemove" onclick="removeButton(this)">x</button></div>');
						$( ".ingredient" ).autocomplete({
				   source: "addMenuAjax.php",
				   select:function(event, ui){
						completeMeasurement(event.target,ui.item);
				   }
					});
						$( ".measurement" ).autocomplete({
					   source: "addMeasurementAjax.php"
					});

				if($(".addRemove").length == 2){
					var add = $(".addRemove:first");
					var dnode = $(".ing-group:first");
					add.removeClass("disabled");
					add.attr('onclick', '').click(removeButton(add));
				}
			}
			function editMoreButton(){
            var index = ($(".editIngredient").length)+1;
				$("#editingredient_row").append('<div id="parentDiv"><div class="ing-group input-group col-md-5" style="margin-right:5px"><span class="input-group-addon">Ingredient</span><input type="text" id="editIngredient" name="ingredient[]" onkeyup="editCompleteMeasurement(this)" class="form-control editIngredient" placeholder="Ingredient name" autocomplete="off"></div><div class="input-group col-md-2" style="margin-right:5px"><input type="number" id="editIngredient_quantity" name="ingredient_quantity[]" class="form-control" placeholder="Quantity" min="0.25" step="0.25" required></div><div class="input-group col-md-2" style="margin-right:5px"><input type="text" id="editIngredient_measurement'+index+'" name="ingredient_measurement[]" class="form-control editMeasurement" placeholder="e.g. pc, cup, etc."></div><button type="button" class="btn btn-danger editRemove" onclick="removeButton(this)">x</button></div>');
						$( ".editIngredient" ).autocomplete({
				   source: "addMenuAjax.php",
				   select:function(event, ui){
						editCompleteMeasurement(event.target,ui.item);
				   }
					});
						$( ".editMeasurement" ).autocomplete({
					   source: "addMeasurementAjax.php"
					});

				if($(".editRemove").length == 2){
					var edit = $(".editRemove").first();
					edit.removeClass("disabled");
				//	edit.click(removeButton(this));
				}
			}
			function removeButton(e){
				e.parentNode.remove();

				if($(".addRemove").length == 1){
					var add = $(".addRemove").first();
					add.addClass("disabled");
				//	add.off("click");
				}
				if($(".editRemove").length == 1){
					var add = $(".editRemove").first();
					add.addClass("disabled");
				//	add.off("click");
				}
			}
			function view(id){
				$.post("adminViewMenu.php",{id:id},function(data){
					$("#viewBody").html(data);
				});

			}

			function deleteMenuItem(item, name){
				$(".deletemenu:first").html(name);
				$(".deletemenu:last").html(name);
				$("#delmenu").val(item);
				$("#delmenuname").val(name);
/*				$.post("deleteMenuAjax.php", {item: item}, function(data, status){
					$(".deletemenu:first").html(data);
					$(".deletemenu:last").html(data);
					$("#delmenu").val(item);	
				});*/
			}

			function liveSearch(page,active) {
				var search1 = $("#searchbox").val();
				if (active == "") {
					var active = $("ul#tabs").children("li[class^='active']").attr("id");
				}
				$.post("adminMenuSearch.php", {search:search1, active:active, page:page}, function(data) {
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
					}else if (active == "Others") {
						$("#menu5").find("tbody").html(data);
					}
				});
			}

			$(function() {
					$( ".ingredient" ).autocomplete({
				   source: "addMenuAjax.php",
				   select:function(event, ui){
						completeMeasurement(event.target,ui.item);
				   }
				});
					$( ".measurement" ).autocomplete({
				   source: "addMeasurementAjax.php"
				});
			});

			$(function() {
					$( ".editIngredient" ).autocomplete({
				   source: "addMenuAjax.php",
				   select:function(event, ui){
						editCompleteMeasurement(event.target,ui.item);
				   }
				});
					$( ".editMeasurement" ).autocomplete({
				   source: "addMeasurementAjax.php"
				});
			});

         function completeMeasurement(input,e){
            var ingredient = e.value;
            var index = $(".ingredient").index(input)+1;
            if(ingredient != ""){
               $.post("autoMeasurementAjax.php", {ingredient: ingredient}, function(data){
                  $("#ingredient_measurement"+index+"").val(data);

               });
            }
         }

         function editCompleteMeasurement(input,e){
            var ingredient = e.value;
            var index = $(".editIngredient").index(input) + 1;
            if(ingredient != ""){
               $.post("autoMeasurementAjax.php", {ingredient: ingredient}, function(data){
                  $("#editIngredient_measurement"+index+"").val(data);

               });
            }
         }

			function showEditedItem(item) {
				dismissEdit();

				$.post("editMenuAjax.php", {item: item}, function(data,status){
					var init = data.replace(/"/g, "");
					var zero = init.split("[[");
					var m = zero[0].split("[");
					var i = zero[1].replace(/],/g, "").replace("]]]", "");

					var menu = m[1].split(",");

					$("#menuname").html(menu[1]);

					$("#editMenu_item").val(menu[1]);
					$("#editIngredient_category").val(menu[2]);
					$("#editPrice").val(menu[3]);
					$("#editIngredient_status").val(menu[4]);

					var ingr = i.split("[");

					var in1 = ingr[0].split(",");

					$("#editIngredient_quantity").eq(0).val(in1[1]);
					$("#editIngredient").eq(0).val(in1[0]);
					$("#editIngredient_measurement1").eq(0).val(in1[2]);

					var count = 1;
					while(ingr[count] != null){	//if more than one ingredient
						var in2 = ingr[count].split(",");

					var index = ($(".editIngredient").length)+1;
						$("#editingredient_row").append('<div id="parentDiv" class="dynamicIngr"><div class="input-group col-md-5" style="margin-right:5px"><span class="input-group-addon">Ingredient</span><input type="text" id="editIngredient" name="ingredient[]" onkeyup="editCompleteMeasurement(this)" value="'+in2[0]+'" class="form-control editIngredient ingrName" placeholder="Ingredient name" autocomplete="off"></div><div class="input-group col-md-2" style="margin-right:5px"><input type="number" id="editIngredient_quantity" name="ingredient_quantity[]" value="'+in2[1]+'" class="form-control ingrQty" placeholder="Quantity" min="0.25" step="0.25" required></div><div class="input-group col-md-2" style="margin-right:5px"><input type="text" id="editIngredient_measurement'+index+'" name="ingredient_measurement[]" value="'+in2[2]+'" class="form-control editMeasurement" placeholder="e.g. pc, cup, etc."></div><button type="button" class="btn btn-danger editRemove" onclick="removeButton(this)">x</button></div>');
								$( ".editIngredient" ).autocomplete({
						   source: "addMenuAjax.php"
							});
								$( ".editMeasurement" ).autocomplete({
							   source: "addMeasurementAjax.php"
							});

						count++;
						if($(".editRemove").length == 2){
							var edit = $(".editRemove").first();
							edit.removeClass("disabled");
						}
					}
				});

			}

			function dismissEdit(){
				$(".dynamicIngr").remove();


				$("#menuname").html("");

				$("#editMenu_item").val("");
				$("#editIngredient_category").val("");
				$("#editPrice").val("");
			}

			function disableRemoveButton(){
				var add = $(".addRemove").first();
			}
		</script>
	</head>
	<nav class="navbar navbar-custom no-margin navbar-fixed-top">
	<div class="navbar-header">
		<a class="navbar-brand" href="overview.html"><img src="imgs/logo.png" class="pull-left"/><span><b>CAFE</b> DIEM</span></a>
	</div>

	<ul class="nav navbar-nav navbar-right">
		<li class="logout-btn"><a href="../CDMIS/" style="margin-right:14px;">Logout</a><li>
	</ul>
	</nav>
	<body>
	<?php
		$account_id = $_SESSION['account_id'];
		$account_name = $_SESSION['account_name'];

		if(isset($_POST['add_submit'])){
			$menu_item=$_POST['menu_item'];
			$ingredient=$_POST['ingredient'];
			$ingredient_quantity=$_POST['ingredient_quantity'];
			$category=$_POST['ingredient_category'];
			$measurement=$_POST['ingredient_measurement'];
			$msr_array = Array();
			$price=$_POST['price'];

			$db->select("SELECT * FROM menu WHERE menu_name='$menu_item'");
			if($db->affected()==0){

				if(isset($ingredient) && isset($ingredient_quantity)){
					$db->query("INSERT INTO menu VALUES(0, '$menu_item', '$category', '$price', 1, 0)");
					$menu_id = $db->insertID();

					$logMsg = "added menu: ".$menu_item.".";
					$db->query("INSERT INTO logs VALUES(0, '$logMsg', $account_id, NOW())");

					foreach($measurement as $msr){	//check if measurement exist
						$msrcheck = $db->select("SELECT measurement_id FROM measurements WHERE measurement_name = '$msr'");
						$exist_msr = $db->affected();
						if($exist_msr < 1){		//if not, add measurement
							$ins_msr = $db->query("INSERT INTO measurements VALUES(0, '$msr')");
							$msr_id = $db->insertID();
							$msrLogMsg = "added measurement: ".$msr.".";
							$db->query("INSERT INTO logs VALUES(0, '$msrLogMsg', $account_id, NOW())");
						}
						else{
							$row=$db->fetch($msrcheck);
							$msr_id=$row['measurement_id'];
						}
						array_push($msr_array, $msr_id);
					}

					$i=0;
					foreach($ingredient as $ingr) {	//check if ingredients exist

						$resultcheck = $db->select("SELECT ingredient_id FROM ingredients WHERE ingredient_name = '$ingr'");
						$exist_ing = $db->affected();
						if($exist_ing < 1){		//if not, add ingredient
							$ins = $db->query("INSERT INTO ingredients VALUES(0, '$ingr', '0', '$msr_array[$i]')");
							$ing_id = $db->insertID();
							$ingrLogMsg = "added ingredient: ".$ingr.".";
							$db->query("INSERT INTO logs VALUES(0, '$ingrLogMsg', $account_id, NOW())");
						}
						else{
							$row=$db->fetch($resultcheck);
							$ing_id=$row['ingredient_id'];
						}
						$db->query("INSERT INTO recipe VALUES(0, '$menu_id', '$ing_id', '$ingredient_quantity[$i]')");
					//	mysqli_query($con,"insert into recipe values('$menu_id', '$ing_id', '$temp_ingredient_quantity')");
						$i+=1;
					}
				}
			}
		}

		else if(isset($_POST['edit_submit'])){
			$menu_item=$_POST['menu_item'];
			$ingredient=$_POST['ingredient'];
			$ingredient_quantity=$_POST['ingredient_quantity'];
			$category=$_POST['ingredient_category'];
			$measurement=$_POST['ingredient_measurement'];
			$status=$_POST['ingredient_status'];
			$msr_array = Array();
			$price=$_POST['price'];
			$not_exist = Array();
			$getID = $db->select("select * from menu where menu_name='$menu_item'");
			if($db->affected() > 0){

				while($getrow = $db->fetch($getID)){
					$itemID = $getrow['menu_id'];
				}

				$db->query("update menu set menu_name = '$menu_item', category = '$category', price = '$price', menu_status = '$status' where menu_id = $itemID");
				$menu_id = $itemID;

				$db->query("delete from recipe where menu_id = $menu_id");

				foreach($measurement as $msr){	//check if measurement exist
					$msrcheck = $db->select("select measurementID from measurements where measurementName = '$msr'");
					$exist_msr = $db->affected();
					if($exist_msr < 1){		//if not, add measurement
						$ins_msr = $db->query("insert into measurements values(0, '$msr')");
						$msr_id = $db->insertID();
					}
					else{
						$row=$db->fetch($msrcheck);
						$msr_id=$row['measurementID'];
					}
					array_push($msr_array, $msr_id);
				}


				$i=0;
				foreach($ingredient as $ingr) {	//check if ingredients exist
					$resultcheck = $db->select("select ingredient_id from ingredients where ingredient_name = '$ingr'");
					$exist_ing = $db->affected();
					if($exist_ing < 1){		//if not, add ingredient
						$ins = $db->query("insert into ingredients values(0, '$ingr', '$ingredient_quantity[$i]', '$msr_array[$i]')");
						$ing_id = $db->insertID();
					}
					else{
						$row=$db->fetch($resultcheck);
						$ing_id=$row['ingredient_id'];
					}
					$db->query("insert into recipe values(0, '$menu_id', '$ing_id', '$ingredient_quantity[$i]')");
				//	mysqli_query($con,"insert into recipe values('$menu_id', '$ing_id', '$temp_ingredient_quantity')");
					$i+=1;
				}
			}

		}
		else if(isset($_POST['delete_submit'])){
			$menu_id = $_POST['del_menu_id'];
			$menu_name = $_POST['del_menu_name'];
			$db->select("SELECT recipe_id FROM recipe WHERE menu_id = '$menu_id'");
			$withrecipe_success = $db->affected();
			if($withrecipe_success > 0){
				$db->query("DELETE from recipe WHERE menu_id = '$menu_id'");
				$recipe_success = $db->affected();
			}
			$db->query("DELETE FROM menu where menu_id= '$menu_id'");
			$menu_success = $db->affected();
			if(($withrecipe_success == $recipe_success) && ($recipe_success > 0) && ($menu_success > 0)){
				$logMsg = "deleted menu: ".$menu_name.".";
				$db->query("INSERT INTO logs VALUES(0, '$logMsg', $account_id, NOW())");
			}
		}
	?>
	<div class="row content">
		<?php
			include("sidebar.php");
			sidebar("menu");
		?>
		<div id="wrapper" class="col-md-9">
			<div class="container-fluid">
				<h1 class="primary">Menu Items</h1>
				<hr>
				<div class="row">
					<div class="col-md-10">
						<div class="input-group">
							<input type="text" class="form-control" onkeyup="liveSearch(1,'')" placeholder="Search" id="searchbox"/>
							<span class="input-group-btn">
								<button class="btn btn-primary btn-search" type="button" onclick="liveSearch(1,'')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</span>
						</div>
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-success form-control" data-target="#addModal" data-toggle="modal" onclick="disableRemoveButton()">Add</button>
					</div>
				</div>
				<div id='searchbody'>
					<ul id='tabs' class="nav nav-tabs pads-top">
						<li class="active" id='all'><a data-toggle="tab" href="#home" onclick='liveSearch(1, "all")'>All</a></li>
						<li id='All-day'><a data-toggle="tab" href="#menu1" onclick='liveSearch(1, "All-day")'>All-day Breakfast</a></li>
						<li id="Waffles"><a data-toggle="tab" href="#menu2" onclick='liveSearch(1, "Waffles")'>Waffles & Pancakes</a></li>
						<li id="Pizza"><a data-toggle="tab" href="#menu3" onclick='liveSearch(1, "Pizza")'>Pizzas & Quesadillas</a></li>
						<li id="Drinks"><a data-toggle="tab" href="#menu4" onclick='liveSearch(1, "Drinks")'>Drinks</a></li>
						<li id="Others"><a data-toggle="tab" href="#menu5" onclick='liveSearch(1, "Others")'>Others</a></li>
					</ul>

					<div class="tab-content clearfix">
						<div id="home" class="tab-pane fade in active">
							<table class="table table-striped">
								<thead>
									<tr>
										<th class="col-md-8">Menu Item</th>
										<th>Price</th>
										<th>Status</th>
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
										<th class="col-md-8">Menu Item</th>
										<th>Price</th>
										<th>Status</th>
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
										<th class="col-md-8">Menu Item</th>
										<th>Price</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<script>liveSearch(1, "Waffles")</script>
								</tbody>
							</table>
						</div>
						<div id="menu3" class="tab-pane fade">
							<table class="table table-striped">
								<thead>
									<tr>
										<th class="col-md-8">Menu Item</th>
										<th>Price</th>
										<th>Status</th>
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
										<th class="col-md-8">Menu Item</th>
										<th>Price</th>
										<th>Status</th>
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
										<th class="col-md-8">Menu Item</th>
										<th>Price</th>
										<th>Status</th>
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
			</div>
		</div>

		<div id="editModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Editing <span id="menuname">		</span>
					</div>
					<div class="modal-body form-center text-center">
						<form action="#" method="post" role="form" class="form-inline">
							<div class="row">
									<div class="input-group col-md-10" style=" margin-bottom: 5px;">
										<span class="input-group-addon">
											Menu Item
										</span>
										<input type="text" id="editMenu_item" name="menu_item" class="form-control" placeholder="Menu Item" required pattern="[a-zA-Z ]{1,50}" title="e.g. Hotsilog">
									</div>
							</div>
							<div class="row" id="editingredient_row">
									<div id='parentDiv'>
										<div class="input-group col-md-5">
											<span class="input-group-addon">
												Ingredient
											</span>
											<input type="text" id="editIngredient" name="ingredient[]" onkeyup="editCompleteMeasurement(this)" class="form-control editIngredient" pattern="[a-zA-Z\s]{1,30}" title="e.g. Hotdog" required>
										</div>
										<div class="input-group col-md-2">
											<input type="number" id="editIngredient_quantity" name="ingredient_quantity[]" class="form-control"	placeholder="Quantity" min='0.25' step='0.25' required>
										</div>
										<div class="input-group col-md-2">
											<input type="text" id="editIngredient_measurement1" name="ingredient_measurement[]" class="form-control editMeasurement" placeholder="e.g. pc, cup, etc." required>
										</div>


										<button type="button" class="btn btn-danger editRemove disabled">x</button>
									</div>
							</div>
							<div id="editMore"><button type="button"  style=" margin-top: 5px;"class="btn btn-success" onclick="editMoreButton()">Add More Ingredients</button></div>
							<div class="input-group col-md-10" style=" margin-top: 5px;">
											<span class="input-group-addon">
												Category
											</span>
											<select  id="editIngredient_category" name="ingredient_category" class="form-control" required>
												<option>Select Category</option>
												<option value='all-day-breakfast' > All-Day Breakfast</option>
												<option value='drinks' > Drinks</option>
												<option value='pizza-quesadillas' > Pizza and Quesadillas</option>
												<option value='waffles-pancakes' > Waffles and Pancakes</option>
												<option value='others' > Others</option>
											</select>
							</div>
							<div class="row">
									<div class="input-group col-md-10" style=" margin-top: 5px;">
										<span class="input-group-addon">
											Price
										</span>
										<input type="text" id="editPrice" name='price' class="form-control" placeholder="0" pattern="[0-9]+([\.,][0-9]+)?" title="Numbers only (0-9)" required >
									</div>
							</div>
							<div class="input-group col-md-10" style=" margin-top: 5px;">
								<span class="input-group-addon">
									Status
								</span>
								<select  id="editIngredient_status" name="ingredient_status" class="form-control" required>
									<option>Select Status</option>
									<option value='1'
										<?php	if(isset($_SESSION['status']) and ($_SESSION['status'] == 1)){
															echo " selected";
														}	?>	> Available</option>
									<option value='0'
										<?php	if(isset($_SESSION['status']) and ($_SESSION['status'] == 0)){
															echo " selected";
														}	?>	> Not Available</option>
								</select>
							</div> <br/>
							<button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: 5px;">Cancel</button>
							<input type="submit" id="submit" name='edit_submit' class="form-control btn btn-success" style="margin-top: 5px;" value="Edit">
						</form>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick ="dismissEdit()">Close</button>
					</div>
				</div>
			</div>
		</div>

		<div id="deleteModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Deleting <span class="deletemenu" id="deletemenuname">		</span>
					</div>
					<div class="modal-body text-center">
					<p>Are you sure you want to delete <span class="deletemenu">		</span> ?</p>
					<form method="post" action="#"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<input type="hidden" name="del_menu_name" id="delmenuname">
					<input type="hidden" name="del_menu_id" id="delmenu">
					<input type="submit" class="btn btn-success" name="delete_submit" value="Delete"></form>
					</div>
				</div>
			</div>
		</div>

		<div id="viewModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Viewing <span id="viewName"></span>
					</div>
					<div class="modal-body">
					<div class="list-group" id='viewBody'>

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
					<div class="modal-body form-center text-center" id='addModalBody'>
						<form action="#" method="post" role="form" class="form-inline">
							<div class="row">
									<div class="input-group col-md-10" style=" margin-bottom: 5px;">
										<span class="input-group-addon">
											Menu Item
										</span>
										<input type="text" id="menu_item" name="menu_item" class="form-control" placeholder="Menu Item" pattern="[a-zA-Z\s]{1,30}" title="e.g. Hotsilog" required
											value="<?php	if(isset($_SESSION['menu_item'])){
																		echo $_SESSION['menu_item'];
																	}	?>"	>
									</div>
							</div>
							<div id="suggestion" style='background:red;'></div>
							<div class="row" id="ingredient_row">
									<div id='parentDiv'>
										<div class="ing-group input-group col-md-5">
											<span class="input-group-addon">
												Ingredient
											</span>
											<input type="text" id="ingredient" name="ingredient[]" onkeyup="completeMeasurement(this)" class="form-control ingredient" placeholder="Ingredient name"  pattern="[a-zA-Z\s]{1,30}" title="e.g. Hotdog" required>
										</div>
										<div class="input-group col-md-2">
											<input type="number" id="ingredient_quantity" name="ingredient_quantity[]" class="form-control" placeholder="Quantity" min='0.25' step='0.25' required>
										</div>
										<div class="input-group col-md-2">
											<input type="text" id="ingredient_measurement1" name="ingredient_measurement[]" class="form-control measurement" placeholder="e.g. pc, cup, etc." required>
										</div>



										<button type="button" class="btn btn-danger addRemove disabled">x</button>
									</div>
							</div>
							<div id="editMore"><button type="button"  style=" margin-top: 5px;"class="btn btn-success" onclick="addMoreButton()">Add More Ingredients</button></div>
							<div class="input-group col-md-10" style=" margin-top: 5px;">
											<span class="input-group-addon">
												Category
											</span>
											<select  id="ingredient_category" name="ingredient_category" class="form-control" required>
												<option>Select Category</option>
												<option value='all-day-breakfast'
													<?php	if(isset($_SESSION['category']) and ($_SESSION['category'] == "all-day-breakfast")){
																		echo " selected";
																	}	?>	> All-Day Breakfast</option>
												<option value='drinks'
													<?php	if(isset($_SESSION['category']) and ($_SESSION['category'] == "drinks")){
																		echo " selected";
																	}	?>	> Drinks</option>
												<option value='pizza-quesadillas'
													<?php	if(isset($_SESSION['category']) and ($_SESSION['category'] == "pizza-quesadillas")){
																		echo " selected";
																	}	?>	> Pizza and Quesadillas</option>
												<option value='waffles-pancakes'
													<?php	if(isset($_SESSION['category']) and ($_SESSION['category'] == "waffles-pancakes")){
																		echo " selected";
																	}	?>	> Waffles and Pancakes</option>
												<option value='others'
													<?php	if(isset($_SESSION['category']) and ($_SESSION['category'] == "others")){
																		echo " selected";
																	}	?>	> Others</option>
											</select>
							</div>
							<div class="row">
									<div class="input-group col-md-10" style=" margin-top: 5px;">
										<span class="input-group-addon">
											Price
										</span>
										<input type="text" id="price" name='price' class="form-control" placeholder="0" pattern="[0-9]+([\.,][0-9]+)?" title="Numbers only (0-9)" required
											value="<?php	if(isset($_SESSION['price'])){
																		echo $_SESSION['price'];
																	}	?>"	>
									</div>
							</div>
							<button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: 5px;">Cancel</button>
							<input type="submit" id="submit" name='add_submit' class="form-control btn btn-success" style="margin-top: 5px;" value="Add">
						</form>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<div id="addIngrModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Adding new menu item
					</div>
					<div class="modal-body form-center text-center" id='addModalBody'>
						<form action="#" method="post" role="form" class="form-inline">

							Would you like to add the ingredients?

							<button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: 5px;">No</button>
							<input type="submit" id="submit" name='add_ingr' class="form-control btn btn-success" style="margin-top: 5px;" value="Yes">
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
