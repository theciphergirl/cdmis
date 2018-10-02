<?php
function sidebar($active) {
	echo '<div id="sidebar" class="col-md-3">
	<ul>';
	if ($active == "overview") {
		echo "<li class='active'>";
	} else {
		echo "<li>";
	}
		echo '<a href="overview.php">OVERVIEW</a></li>';
	
	echo "<li>MANAGE</li><ul>";
	if ($active == "menu") {
		echo "<li class='active'>";
	} else {
		echo "<li>";
	}	
	echo '<a href="menu.php">Menu Items</a></li>';
	
	if ($active == "ingredients") {
		echo "<li class='active'>";
	} else {
		echo "<li>";
	}
	echo '<a href="ingredients.php">Ingredients</span></a></li>';

	if ($active == "accounts") {
		echo "<li class='active'>";
	} else {
		echo "<li>";
	}
	echo '<a href="accounts.php">Accounts</a></li>';
	
	if ($active == "logs") {
		echo "<li class='active'>";
	} else {
		echo "<li>";
	}
	echo '<a href="logs.php">Logs</a></li>';
	echo '</ul>
	</ul>
	</div>';
}
?>