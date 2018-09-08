<?php
	include 'header.php';

echo '<div class="container">
	<h1>
		Welcome Customer '.$_COOKIE["user"].'
	</h1>
	<br>
	<a href="/new_booking.php" class="btn btn-info">New Bookings</a>
	
<br><br>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Date</th>
      <th scope="col">Pickup</th>
      <th scope="col">Destination</th>
	  <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>';
  
  include_once 'mysqli.php';
  if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);
	
  $query = "SELECT * FROM `booking` WHERE `user_id` = ".$_COOKIE['user'];
				
	$result = mysqli_query($mysqli, $query);
	
	 while ($row=mysqli_fetch_assoc($result))
    {
	echo '<tr>
      <th scope="row">'.$row['booking_id'].'</th>
      <td>'.$row['date'].'</td>
      <td>'.$row['pickup'].'</td>
      <td>'.$row['destination'].'</td>
	  <td>'.$row['status'].'</td>
	</tr>';
	
	}

echo '</tbody>
</table>

</div>';

	include 'footer.php';
?>
