<?php
	include 'header.php';
	
echo '<div class="container">
	<h1>
		Welcome '.get_fullname($_COOKIE["user"]).'
	</h1>
	<br>
	<a href="/new_drivers.php" class="btn btn-info">Add new Drivers</a>
	<a href="/new_admin.php" class="btn btn-info">Add new Admins</a>
	<a href="/new_vehicles.php" class="btn btn-info">Add new vehicles</a>
	
	<a href="/view_bookings.php" class="btn btn-info">view bookings</a>
	<a href="/view_drivers.php" class="btn btn-info">view drivers</a>
	
	<a href="#" class="btn btn-info">monthly report</a>
	
<br><br>

<h1>Stats</h1>';

 include_once 'mysqli.php';
  if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);

  $query = "SELECT COUNT(user_id) as no_users, `group` FROM `users` GROUP BY `group` ";
				
	$result = mysqli_query($mysqli, $query);

	while($row=mysqli_fetch_assoc($result))
    {
		echo '<div><h2>'.$row['group'].'s - '.$row['no_users'].'</h2></div>';
	}
	
echo '</div>';

	include 'footer.php';
?>
