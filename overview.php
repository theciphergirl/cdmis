<!DOCTYPE html>
<?php
	session_start();
	require "database/database.php";
	$db = new Database();
	if(!isset($_SESSION['user'])){
		header("Location:../CDMIS/");
	} else if ($_SESSION['user_type'] != "1") {
		header("Location:../CDMIS/");
	}
?>
<html lang="en">
	<head>
		<title></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/style.css" />
		<script src="jquery/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
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
			sidebar("overview");
			
		?>
		<div id="wrapper" class="col-md-9">
			<div class="container-fluid">
				<h1 class="primary">Overview</h1>
				<hr>
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-blue">
							TODAY'S ORDERS
							<h2 class="text-right">
								<?php
									$db->query("SELECT * FROM orders WHERE order_date = CURDATE() AND status = 'Paid'");
									$row=$db->affected();
									if($row < 0){	echo "0";	}
									else{	echo $row;	}
								?>
							</h2>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-brightblue">
							TODAY'S EARNINGS
							<h2 class="text-right">
								<?php
									$total=0;
									$r = $db->select("SELECT * FROM orders WHERE order_date = CURDATE() AND status = 'Paid'");
									if($db->affected() > 0){
										while($rows=$db->fetch($r)){
											$temp_total=($rows['bill']-($rows['bill']*($rows['discount']/100)));
											$total+=$temp_total;
										}
									}
									echo "Php " . number_format($total, 2);
								?>
							</h2>
						</div>
					</div>
				</div>
				<?php	include("displayBestsellers.php");	?>
			</div>
		</div>
	</div>
	</body>
</html>
