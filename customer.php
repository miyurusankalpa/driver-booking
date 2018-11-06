<?php
	include 'header.php';
	
	if(@$_SESSION["group"]!=="Customer") {
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
	<a href="/new_booking.php" class="btn btn-info">Book new trip</a>
	
<br><br>
<div id="msg_status"></div>
<br>';

  include_once 'mysqli.php';
  if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);
	
  $query = "SELECT b.booking_id, b.date, m.pickup, m.destination, b.status FROM `booking` b, `maps_location` m WHERE b.`user_id` = ".$_COOKIE['user']." AND b.`booking_id`=m.`booking_id`";
				
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
			if($row['status']<5) $cancel = '<a href="#" id="cancel_btn" data-booking-id="'.$row['booking_id'].'" class="btn btn-secondary btn-danger">cancel</a>'; else $cancel = '';
			if($row['status']>6) {
				$b = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT bill_id FROM `billing` WHERE `trip_id` = '".$row['booking_id']."'"));

				$bill = '<a href="/bill.php?id='.$b['bill_id'].'" class="btn btn-secondary btn-info">bill</a>';} else $bill = '';

				echo '<tr>
				  <th scope="row">'.$row['booking_id'].'</th>
				  <td>'.$row['date'].'</td>
				  <td>'.$row['pickup'].'</td>
				  <td>'.$row['destination'].'</td>
				  <td id="bo_status'.$row['booking_id'].'"><div class="badge badge-'.booking_status2text($row['status'],0).'">'.booking_status2text($row['status'],1).'</div> </td>
					<td><div class="btn-group float-right" role="group">
						<a href="status_booking.php?id='.$row['booking_id'].'" class="btn btn-secondary btn-success">status</a>
						'.$cancel.''.$bill.'
					</div>
					</td>
				</tr>';
			}

		echo '</tbody>
		</table>';
	}
 ?>
</div></div>
<script type="text/javascript">
j(document).ready(function () {
    j('#cancel_btn').click(function (e) {

	e.preventDefault();

	var bid = j(this).data("booking-id");

	j.ajax({
	   type: "POST",
	   dataType: 'json',
	   url: "new_booking_process.php",
	   data: 'booking_id='+ bid +'&cancel_booking=true&json=true',
	   cache: false,
	   success: function(data){
				if(data.result=="error"){
					j("#msg_status").html('<div class="alert alert-warning">'+ data.message +'</div>').fadeIn("slow").delay(5000).fadeOut("slow");
				}
				if(data.result=="success"){
					j("#msg_status").html('<div class="alert alert-success">'+ data.message +'</div>').fadeIn("slow").delay(5000).fadeOut("slow");
					j("#bo_status"+bid).fadeOut("slow").html('<?php echo '<div class="badge badge-'.booking_status2text(9,0).'">'.booking_status2text(9,1).'</div>'; ?>').fadeIn("slow");
					j(this).hide();
				}
			},
		error: function(jqXHR,error, errorThrown){
			j("#msg_status").html('<div class="alert alert-danger">OH! :O There was a unexpected error :(</div>').fadeIn("slow").delay(5000).fadeOut("slow");
			j('input').attr('disabled', false);
		}
		});
	});
});
</script>

<?php
	include 'footer.php';
?>
