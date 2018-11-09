<?php
	include 'header.php';
	
echo '<div class="container">
	<h1>
		View Last 10 bookings
	</h1>
	<br>
	
<br><br>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">User</th>
	  <th scope="col">Driver</th>
	  <th scope="col">Amt</th>
	  <th scope="col"></th>
    </tr>
  </thead>
  <tbody>';
  
  include_once 'mysqli.php';
  if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);

  $query = "SELECT * FROM `booking` ";
				
	$result = mysqli_query($mysqli, $query);

	while($row=mysqli_fetch_assoc($result))
    {
		echo '<tr>
		  <th scope="row">'.$row['booking_id'].'</th>
		  <td>'.get_fullname($row['user_id']).'</td>
		  <td>'.get_fullname($row['driver_id']).'</td>
		  <td>100 LKR</td>
		  <td>
			<div class="btn-group" role="group">
				<a href="status_booking.php?id='.$row['booking_id'].'" class="btn btn-secondary btn-info">Trip Report</a>
			</div>
			</td>
		</tr>';
	}

echo '</tbody>
</table>

</div>';

	include 'footer.php';
?>
