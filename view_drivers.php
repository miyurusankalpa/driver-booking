<?php
	include 'header.php';
	
echo '<div class="container">
	<h1>
		Driver list
	</h1>
	<br>
	
<br><br>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
	  <th scope="col">Trips</th>
	  <th scope="col"></th>
    </tr>
  </thead>
  <tbody>';
  
  include_once 'mysqli.php';
  if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);

  $query = "SELECT u.user_id, u.firstname, u.lastname, count(b.booking_id) as trips FROM `users` u, `booking` b WHERE u.group = 'Driver' AND u.user_id=b.driver_id GROUP BY b.driver_id ";
				
	$result = mysqli_query($mysqli, $query);

	while($row=mysqli_fetch_assoc($result))
    {
		echo '<tr>
		  <th scope="row">'.$row['user_id'].'</th>
		  <td>'.$row['firstname'].' '.$row['lastname'].'</td>
		  <td>'.$row['trips'].'</td>
		  <td>
			<div class="btn-group" role="group">
				<a href="monthly_report_driver.php?id='.$row['user_id'].'" class="btn btn-secondary btn-info">View Driver Report</a>
			</div>
			</td>
		</tr>';
	}

echo '</tbody>
</table>

</div>';

	include 'footer.php';
?>
