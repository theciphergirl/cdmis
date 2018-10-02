<?php
	require_once "database/database.php";
	$db = new Database();
	$item = $_POST['item'];
	$delete = "DELETE FROM menu WHERE menu_id='$item'";
	$db->query($delete);
?>
