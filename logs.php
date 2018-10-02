<?php
	session_start();
	require "database/database.php";
	$db = new Database();
	if(!isset($_SESSION['user'])){
		header("Location:../CDMIS/");
	} elseif ($_SESSION['user_type'] != "1") {
		header("Location:../CDMIS/");
	}
	$account_id = $_SESSION['account_id'];
	$account_name = $_SESSION['account_name'];
?>
	
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
		<!--<script src="script.js"></script>-->
		<script src="js/ajaxscripts.js"></script>
		<link rel="stylesheet" href="jquery/jquery-ui.min.css" />
		<link rel="stylesheet" href="css/style.css" />		
		<script type="text/javascript" src="jquery/jquery-1.9.0.min.js"></script>
		<script src="jquery/initial/initial.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="jquery/resizeElements.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>

		<style type="text/css">
			.show_more {
				font-size: 1.6vw;
				color: green;

			}
			.show_more:hover {
				cursor: pointer;
			}
			
		</style>
		<script>
			function liveSearch(page,active) {
				var search = $("#searchbox").val();
				if (active == "") {
					var active = $("ul#tabs").children("li[class^='active']").attr("id");
				}
				$.post("logAjax.php", {search:search, active:active, page:page}, function(data) {
					if (active == "All") {
						$("#log1").find("tbody").html(data);
					} else if (active == "Account") {
						$("#log2").find("tbody").html(data);
					} else if (active == "Menu") {
						$("#log3").find("tbody").html(data);
					} else if (active == "Ingredients") {
						$("#log4").find("tbody").html(data);
					} else if (active == "Order"){
						$("#log5").find("tbody").html(data);
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
		<?php
			include("sidebar.php");
			sidebar("logs");
		?>

		<div id="wrapper" class="col-md-9">
			<div class="container-fluid">
				<h1 class="primary">Logs</h1>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search" id="searchbox" onkeyup="liveSearch(1, '')"	/>
							<span class="input-group-btn">
								<button class="btn btn-primary btn-search" type="button" onclick="liveSearch(1, '')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</span>
						</div>
					</div>
				</div>
				
				<ul id="tabs" class="nav nav-tabs pads-top">
					<li id="All" class="active"><a data-toggle="tab" href="#log1" onclick='liveSearch(1, "All")'>All Logs</a></li>
					<li id="Account"><a data-toggle="tab" href="#log2" onclick='liveSearch(1, "Account")'>Account</a></li>
					<li id="Menu"><a data-toggle="tab" href="#log3" onclick='liveSearch(1, "Menu")'>Menu</a></li>
					<li id="Ingredients"><a data-toggle="tab" href="#log4" onclick='liveSearch(1, "Ingredients")'>Ingredients</a></li>
					<li id="Order"><a data-toggle="tab" href="#log5" onclick='liveSearch(1, "Order")'>Order</a></li>
				</ul>
				<div class="tab-content clearfix">
					<div id="log1" class="tab-pane fade in active">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-md-7">Acivity Log</th>
									<th>Date</th> 
								</tr>
							</thead>
							
							<tbody class="log_list">
								<script>liveSearch(1, "All")</script>
							</tbody>
						</table>
					</div>
					<div id="log2" class="tab-pane fade in">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-md-7">Acivity Log</th>
									<th>Date</th> 
								</tr>
							</thead>
							
							<tbody class="log_list">
								<script>liveSearch(1, "Account")</script>
								
							</tbody>
						</table>
					</div>
					<div id="log3" class="tab-pane fade in">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-md-7">Acivity Log</th>
									<th>Date</th> 
								</tr>
							</thead>
							
							<tbody class="log_list">
								<script>liveSearch(1, "Menu")</script>
								
							</tbody>
						</table>
					</div>
					<div id="log4" class="tab-pane fade in">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-md-7">Acivity Log</th>
									<th>Date</th> 
								</tr>
							</thead>
							
							<tbody class="log_list">
								<script>liveSearch(1, "Ingredients")</script>
								
							</tbody>
						</table>
					</div>
					<div id="log5" class="tab-pane fade in">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-md-7">Acivity Log</th>
									<th>Date</th> 
								</tr>
							</thead>
							
							<tbody class="log_list">
								<script>liveSearch(1, "Order")</script>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>
</html>

