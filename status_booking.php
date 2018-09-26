<?php
	include 'header.php'; 	
	include_once 'mysqli.php';

	echo '<div class="card card-body bg-light text-center">';

	if(isset($_GET["id"])) {
		
		if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);
		
		$query = "SELECT b.*, m.pickup as pickup_l, m.destination as dest_l, m.distance, m.duration FROM `booking` b, `maps_location` m WHERE b.`booking_id` = ".$_GET["id"]." AND b.`booking_id`=m.`booking_id`";
					
		$row = mysqli_fetch_assoc(mysqli_query($mysqli, $query));
		
		if(!empty($row['booking_id'])) {
			
			echo '<h1>Booking #'.$row['booking_id'].'</h1><hr>';
			
			echo '<div class="row"><div class="col">';
			
			$pickup =  $row["pickup"];
			$dest =  $row["destination"];
			
			echo '<b>Pickup </b><br>'.$row["pickup_l"]; echo "<br>";
			echo '<b>Destination </b><br>'.$row["dest_l"]; echo "<br><br>";
			
			echo '<b>Estimated duration </b><br>'.secondsToTime($row["duration"]); echo "<br>";
			echo '<b>Estimated distance </b><br>'.distance2readable($row["distance"]); echo "<br><br>";
			
			echo '<b>Booking Status </b><br>'.booking_status2text($row["status"]); echo "<br>";
			echo '<b>Booked </b><br>'.time_elapsed($row["booking_time"]); echo "<br><br>";
			
			echo '<b>Time to pickup </b><br>'.time_elapsed($row["date"].$row["time"]); echo "<br>";
			echo '<b>Driver </b><br>'.get_fullname($row["driver_id"]); echo "<br>";
			
			echo '</div><div class="col">';
			
			//echo '<button class="btn btn-info">Load Map</button>';
			
			echo '<div class="embed-responsive embed-responsive-16by9">
			<iframe src="https://www.google.com/maps/embed/v1/directions?key=AIzaSyAVBiTDLtz6mIP1cEF-MFWClav9hPVJzYw&origin='.urlencode($pickup).'&destination='.urlencode($dest).'&avoid=highways" width="896" height="504" frameborder="0" >
			</ifram></div>';
			
			echo '</div></div>';
		
		} else echo 'No such Booking';
	
	} else echo 'Empty ID';
	
	echo '</div>';

	include 'footer.php';
?>