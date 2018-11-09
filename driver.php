<?php
	include 'header.php';
	
	if(@$_SESSION["group"]!=="Driver") {
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
		<a href="/monthly_report_driver.php" class="btn btn-info">monthly report</a>

<br><br>';


  include_once 'mysqli.php';
  if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);

  $query = "SELECT b.booking_id, b.date, m.pickup, m.destination, b.status FROM `booking` b, `maps_location` m WHERE b.`driver_id` = ".$_COOKIE['user']." AND b.`booking_id`=m.`booking_id` AND b.status < 8";
				
	$result = mysqli_query($mysqli, $query);
	$row_cnt = mysqli_num_rows($result);
		
	if($row_cnt==0) echo "<h2>No bookings yet</h2>"; else
	{
	echo '<table class="table">
	  <thead>
		<tr>
		  <th scope="col">#</th>
		  <th scope="col">Date</th>
		  <th scope="col">Pickup</th>
		  <th scope="col">Destination</th>
		  <th scope="col">Status</th>
		  <th scope="col"></th>
		</tr>
	  </thead>
	  <tbody>';
	  
		while($row=mysqli_fetch_assoc($result))
		{
			echo '<tr>
			  <th scope="row">'.$row['booking_id'].'</th>
			  <td>'.$row['date'].'</td>
			  <td>'.$row['pickup'].'</td>
			  <td>'.$row['destination'].'</td>
			 <td id="bo_status'.$row['booking_id'].'"><div class="badge badge-'.booking_status2text($row['status'],0).'">'.booking_status2text($row['status'],1).'</div> </td>
				<td><div class="btn-group float-right" role="group">
					<a href="status_booking.php?id='.$row['booking_id'].'" class="btn btn-secondary btn-success">status</a>
				</div>
				</td>
			</tr>';
		}

	echo '</tbody>
	</table>';
	}
echo '</div></div>';

	include 'footer.php';
?>
