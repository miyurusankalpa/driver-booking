<?php
	include 'header.php';
	
echo '<div class="container">
	<h1>
		Welcome '.get_fullname($_COOKIE["user"]).'
	</h1>
	<br>
	<a href="/new_booking.php" class="btn btn-info">Book new trip</a>
	
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
	
  $query = "SELECT b.booking_id, b.date, m.pickup, m.destination, b.status FROM `booking` b, `maps_location` m WHERE b.`user_id` = ".$_COOKIE['user']." AND b.`booking_id`=m.`booking_id`";
				
	$result = mysqli_query($mysqli, $query);
	
	while($row=mysqli_fetch_assoc($result))
    {
		echo '<tr>
		  <th scope="row">'.$row['booking_id'].'</th>
		  <td>'.$row['date'].'</td>
		  <td>'.$row['pickup'].'</td>
		  <td>'.$row['destination'].'</td>
		  <td>'.booking_status2text($row['status']).' 
			<div class="btn-group float-right" role="group">
				<a href="status_booking.php?id='.$row['booking_id'].'" class="btn btn-secondary btn-success">status</a>
				<a href="#" class="btn btn-secondary btn-danger">cancel</a>
			</div>
			</td>
		</tr>';
	}

echo '</tbody>
</table>

</div>';

	include 'footer.php';
?>
