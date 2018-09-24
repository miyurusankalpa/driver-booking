<?php
	include 'header.php';
	
echo '<div class="container">
	<h1>
		Welcome '.get_fullname($_COOKIE["user"]).'
	</h1>
	<br>
	<a href="/new_drivers.php" class="btn btn-info">Add new Drivers</a>
	<a href="/new_admins.php" class="btn btn-info">Add new Admins</a>
	<a href="/new_vehicles.php" class="btn btn-info">Add new vehicles</a>
	
	<a href="#" class="btn btn-info">view booings</a>
	<a href="#" class="btn btn-info">view drivers</a>
	<a href="#" class="btn btn-info">view admins</a>
	
	<a href="#" class="btn btn-info">monthly report</a>
	
<br><br>

<h1>Daily Stats</h1>

</div>';

	include 'footer.php';
?>
