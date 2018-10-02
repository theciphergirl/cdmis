<!DOCTYPE html>
	<head>
		<title>CDMIS</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/style.css" />
		<script src="jquery/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>

	</head>
	<body>
 		<div id="header" class="container-fluid header">
 			<div class="row">
 				<div class="col-lg-12 ">
	<?php
	session_start();
	require "database/database.php";
	$db = new Database();
	
	$outmsg = "";
	if((isset($_POST['loginadmin']))||(isset($_POST['logincashier']))){
		$uname=$db->escape($_POST['username']);
		$pass=$db->escape($_POST['password']);
		$access_type=$_POST['access_type'];
		
		echo $uname." ".$pass." ".$access_type;
		$loginquery=$db->select("SELECT * FROM account WHERE `account_name`='$uname' AND `password`=md5('$pass')");
		$affected_rows_login=$db->affected();
		if($affected_rows_login==0){
			$outmsg="Sorry, wrong username and/or password";
		}
		else{
			$_SESSION['user'] = $pass;
			$_SESSION['user_type'] = $access_type;
			if(isset($_POST['loginadmin']) && $access_type == 1){
				if($row = $db->fetch($loginquery)){
					$_SESSION['account_id'] = $row['account_id'];
					$_SESSION['account_name'] = $row['account_name'];
				}
				header("Location:overview.php");
			}
			elseif(isset($_POST['logincashier']) && $access_type >= 2){
				if($row = $db->fetch($loginquery)){
					$_SESSION['account_id'] = $row['account_id'];
					$_SESSION['account_name'] = $row['account_name'];
				}
				header("Location:orders.php");
			}
		}
	}
?>
 				</div>
 			</div>
 		</div>
 		<div id="login" class="container pad-top">
 			<div class="row">
 				<div class="col-md-6 login">
	 				<div id="login-pan" class="panel panel-primary">
	  					<div class="panel-heading">
	    					<h3 class="text-center">Login As</h3>
	  					</div>
	  					<div class="panel-body text-center">
	  						 <ul class="nav list-group">
							    <li class="list-group-item" data-target="#admin-modal" data-toggle="modal">Admin</li>
							    <li class="list-group-item" data-target="#cashier-modal" data-toggle="modal">Cashier</li>
							</ul>
	  					</div>
					</div>
				</div>
 			</div>
 		</div>

		<div id="admin-modal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<div class="modal-title"><h3>Login as admin</h3></div>
					</div>
					<div class="modal-body text-center">
						<center><span id="error_msg"><em><?php echo $outmsg?></em></span></center>
						<form action="#" method="post" role="form" class="form-inline">
							<div class="form-group">
								<div class="row">
									<label for="username">Username: </label>
									<input type="text" name="username" class="form-control" placeholder="Enter Username" required pattern="[a-zA-Z0-9]{1,15}" title="e.g. john, john1">   
								</div>
								<div class="row">
									<label for="password">Password: </label>
									<input type="password" name="password" class="form-control" placeholder="Enter password" required pattern=".{6,}" title="Six or more characters">
								</div>
								<input type="hidden" name="access_type" value="1"/>
								<input type="submit" name="loginadmin" class="form-control btn btn-success" style="width: 270px; margin-top: 5px;" value="Login">
							</div>
						</form>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</div>

				</div>
			</div>
		</div>
		
		<div id="cashier-modal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<div class="modal-title"><h3>Login as cashier</h3></div>
					</div>
					<div class="modal-body text-center">
						<center><span id="error_msg"><em><?php echo $outmsg?></em></span></center>
						<form action="#" method="post" role="form" class="form-inline">
							<div class="form-group">
								<div class="row">
									<label for="username">Username: </label>
									<input type="text" name="username" class="form-control" placeholder="Enter Username" required pattern="[a-zA-Z0-9]{1,15}" title="e.g. john, john1">   
								</div>
								<div class="row">
									<label for="password">Password: </label>
									<input type="password" name="password" class="form-control" placeholder="Enter password" required pattern=".{6,}" title="Six or more characters">
								</div>
								<input type="hidden" name="access_type" value="2"/>
								<input type="submit" name="logincashier" class="form-control btn btn-success" style="width: 270px; margin-top: 5px;" value="Login">
							</div>
						</form>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</div>
				</div>
			</div>
		</div>
		
	</body>

</html>

<script>
	
	var url = window.location.href;
	var outmsg = "<?php echo $outmsg; ?>";
	if( outmsg != "") {
		if("<?php echo isset($_POST['loginadmin'])?>"){
			$('#admin-modal').modal('show');
		}
		else if ("<?php echo (isset($_POST['logincashier']))?>"){
			$('#cashier-modal').modal('show');
		}
	}
	$("#admin-modal").on("hidden.bs.modal", function(e){
     $("span#error_msg").hide();
	});
	$("#cashier-modal").on("hidden.bs.modal", function(e){
     $("span#error_msg").hide();
	});

</script>
