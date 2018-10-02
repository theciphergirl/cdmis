<?php
	session_start();
	require "database/database.php";
	$db = new Database();
	if(!isset($_SESSION['user'])){
		header("Location:../CDMIS/");
	} else if ($_SESSION['user_type'] != "1") {
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
		<script src="js/ajaxscripts.js"></script>
		<link rel="stylesheet" href="jquery/jquery-ui.min.css" />
		<link rel="stylesheet" href="css/style.css" />
		<script>
			function search(){
				value = $("#searchbox").val()
				$.post("accountsSearch.php",{value:value},function(data){
					$("#searchbody").html(data);
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
			sidebar("accounts");
		?>
		<div id="wrapper" class="col-md-9">
			<div class="container-fluid">
				<h1 class="primary">Accounts</h1>
				<hr>
				<div class="row">
					<div class="col-md-10">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search" onkeyup="search()" id="searchbox"/>
							<span class="input-group-btn">
								<button class="btn btn-primary btn-search" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</span>
						</div>	
					</div>	
					<div class="col-md-2">
						<button type="button" class="btn btn-success form-control"  data-target="#addModal" data-toggle="modal">Add</button>
					</div>	
				</div>	

				<div class="panel panel-default pads-top text-left">
					<div class="panel-body">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-md-7">Account Name</th>
									<th>Access Type</th> 
									<th></th> 
								</tr>
							</thead>
							<tbody id="searchbody">
								<?php
								$sql="SELECT * FROM account ORDER BY access_type, account_id ASC";
								$result=$db->select($sql);
								while ($row = $db->fetch($result)) {
									echo "<tr>
										<td>" . $row['account_name'] . "</td>
	 									<td>";
									if($row['access_type'] == 1){	echo "Admin";	}
									if($row['access_type'] == 2){	echo "Cashier";	}
									echo "</td>
										<td><span class='icons'><a href='#' onclick=editAccount('".$row['account_id']."') data-target='#editModal' data-toggle='modal'><img src='imgs/edit.png'/></a>
											<a href='#' onclick=deleteAccount('".$row['account_id']."','".$row['account_name']."') data-target='#deleteModal' data-toggle='modal'><img src='imgs/delete.png'/></a></span></td>								
										</tr>";	
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<?php
			if(isset($_POST['edit_submit'])){
				$account_id = $_POST['account_id'];
				$account_name = $_POST['account_name'];
				$account_type = $_POST['account_type'];
				$quantity = $_POST['quantity'];
				$query = $db->select("SELECT * FROM account WHERE account_id='$account_id'");
				$db->query("UPDATE account SET account_name='$account_name', access_type='$account_type' WHERE account_id='$account_id'");
				$affected = $db->affected();
				if($affected==1){
					while($row = $db->fetch($query)){	
						$logMsg = "edited the account of: " . $account_name .".";
						$acct_id = $_SESSION["account_id"];
						$db->query("INSERT INTO logs VALUES(0, '$logMsg', $acct_id, NOW())");
					}
					echo "<script>alert('Account has been edited successfully')</script>";
					printf("<script>location.href='../accounts.php'</script>");		
				}
				elseif($affected == 0){
					echo "<script>alert('No changes has been made.')</script>";
					printf("<script>location.href='../accounts.php'</script>");	
				}
				else{
					echo "<script>alert('There was an error editing the account!')</script>";
				}
			}
		?>

		<div id="editModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<div class="modal-title">Edit Account</div>
					</div>
					<div class="modal-body form-center text-center">
						<form action="#" method="post" role="form" class="form-inline">
							<div class="row">
								<div class="input-group col-md-9" style=" margin-top: 5px;">
									<span class="input-group-addon">
										Account Name
									</span>
									<input type="text" name="account_name" id="account_name" class="form-control" placeholder="Account Name" required pattern="[a-zA-Z0-9 -]{1,15}" title="e.g. frae, frae1">
								</div>
							</div> 
							<div class="row">
								<div class="input-group col-md-9" style=" margin-top: 5px;">
									<span class="input-group-addon">
										Access Type
									</span>
									<select name="account_type" id="account_type" class="form-control" placeholder="Access Type" required pattern="[a-zA-Z]{1,10}">
										<option value="">----------------------------------------</option>
										<option value="2"> Cashier </option>
										<option value="1"> Admin </option>
									</select>
									<input type="hidden" name="account_id" id="account_id" class="form-control">
								</div>
							</div>
							<button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: 5px;">Cancel</button>
							<input type="submit" name="edit_submit" id="edit_submit" class="form-control btn btn-success" style="margin-top: 5px;" value="Save">
						</form>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</div>
				</div>
			</div>
		</div>

		<?php
			if(isset($_POST['delete_submit'])){
				$id = $_POST['acct_id'];
				$query = $db->select("SELECT * FROM account WHERE account_id='$id'");
				$db->query("DELETE FROM account WHERE account_id='$id'");
				$affected = $db->affected();
				if($affected == 1){
					while($row = $db->fetch($query)){
						$logMsg = "deleted account of: ".$row['account_name'].".";
						$db->query("INSERT INTO logs VALUES(0, '$logMsg', $account_id, NOW())");
					}
					echo "<script>alert('Account has been deleted successfully!')</script>";
					printf("<script>location.href='accounts.php'</script>");		
				}
				elseif($affected == 0){
					echo "<script>alert('No changes has been made.')</script>";
					printf("<script>location.href='accounts.php'</script>");	
				}
				else{
					echo "<script>alert('There was an error deleting the account!".$id."')</script>";
				}
			}
		?>

		<div id="deleteModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class='modal-header'>
						Deleting Account
					</div>
					<div class='modal-body text-center modal-delete'>
						Are you sure you want to delete this account?
						<form action="#" method="post" role="form" class="form-inline">
							<input type="hidden" name="acct_id" id="id" class="form-control">
							<button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: 5px;">Cancel</button>
							<input type="submit" name="delete_submit" id="delete" class="form-control btn btn-success" style="margin-top: 5px;" value="Yes">
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php
			if (isset($_POST['add_submit'])) {
				$account_name = $_POST['account_name'];
				$account_type = $_POST['account_type'];
				$password=$_POST['password'];
				$db->query("INSERT INTO account VALUES (0, '$account_name', md5('$password'), '$account_type')");
				
				$affected = $db->affected();
				if($affected==1){
					$logMsg = "added the account of: ".$account_name.".";
					$db->query("INSERT INTO logs VALUES(0, '$logMsg', $account_id, NOW())");
				
					echo "<script>alert('Account has been added successfully!')</script>";
					printf("<script>location.href='accounts.php'</script>");		
				}
				else{
					echo "<script>alert('There was an error in adding the account!')</script>";
				}
			}
		?>

		<div id="addModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<div class="modal-title">Add Account</div>
					</div>
					<div class="modal-body form-center text-center">
						<form action="#" method="post" role="form" class="form-inline">
							<div class="row">
								<div class="input-group col-md-9" style=" margin-top: 5px;">
									<span class="input-group-addon">
										Account Name
									</span>
									<input type="text" name="account_name" id="account_name" class="form-control" placeholder="Account Name"pattern="[a-zA-Z0-9]{1,15}" title="e.g. frae, frae1" required >
								</div>
							</div> 
							<div class="row">
								<div class="input-group col-md-9" style=" margin-top: 5px;">
									<span class="input-group-addon">
										Access Type
									</span>
									<select name="account_type" id="account_type" class="form-control" placeholder="Access Type" min="1" max="3" required pattern="[a-zA-Z]{1,10}" title="must be string">
										<option value="">-------------------------------</option>
										<option value="2"> Cashier </option>
										<option value="1"> Admin </option>
									</select>
								</div>
							</div> 
							<div class="row">
								<div class="input-group col-md-9" style=" margin-top: 5px;">
									<span class="input-group-addon">
										Password
									</span>
									<input type="password" name="password" id="password" class="form-control" placeholder="Password" required pattern=".{6,}" title="Six or more characters">
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