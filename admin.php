<?php
	include 'header.php';
	
	if(!isset($_COOKIE["user"]))
	{
		echo '<div class="container">
		<h2 class="alert alert-danger">You have to login to access this page</h2><br>
		</div>';
		include 'footer.php'; die;
	} else if(@$_SESSION["group"]!=="Admin") {
		echo '<div class="container">
		<h2 class="alert alert-danger">You are no authorized to access this page</h2><br>
		</div>';;
		include 'footer.php'; die;
	}
	
echo '<div class="container"><div class="jumbotron">
	<h1>
		Welcome '.get_fullname($_COOKIE["user"]).'
	</h1>
	<br>
	<a href="/new_drivers.php" class="btn btn-info">Add new Drivers</a>
	<a href="/new_admin.php" class="btn btn-info">Add new Admins</a>
	
	<a href="/view_bookings.php" class="btn btn-info">view bookings</a>
	<a href="/view_drivers.php" class="btn btn-info">view drivers</a>
	
	<a href="/monthly_report.php" class="btn btn-info">monthly report</a>
	
<br><br>
<div class="row"><div class="col">

<h1>Stats - users</h1>';

 include_once 'mysqli.php';
  if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);

  $query = "SELECT COUNT(user_id) as no_users, `group` FROM `users` GROUP BY `group` ";
				
	$result = mysqli_query($mysqli, $query);

	while($row=mysqli_fetch_assoc($result))
    {
		echo '<div><h2>'.$row['group'].'s - '.$row['no_users'].'</h2></div>';
	}
	
echo '</div><div class="col"><br><h1>Stats - bookings</h1>';

	$query = "SELECT COUNT(`booking_id`) as num, `status` FROM `booking` GROUP BY `status` ";
				
	$result = mysqli_query($mysqli, $query);

	while($row=mysqli_fetch_assoc($result))
    {
		echo '<h2><div class="badge badge-'.booking_status2text($row['status'],0).'">'.booking_status2text($row['status'],1).'</div> - '.$row['num']; echo "</h2><br>";
	}
	
	include_once 'prices_data.php';
	
echo '</div></div><br><h1>Pricing</h1>';

	echo '<div><h2>Base price '.$price_data["rs_start"].' LKR</h2></div>';
	echo '<div><h2>Price per minute '.$price_data["rs_per_min"].' LKR</h2></div>';
	//echo '<div><h2>Price per km '.$price_data["rs_per_km"].' LKR</h2></div>';

echo '</div></div>';

	include 'footer.php';
?>
