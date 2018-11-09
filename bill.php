<?php
	include 'header.php'; 	
	include_once 'mysqli.php';

	echo '<div class="card card-body bg-light text-center">';

	if(isset($_GET["id"])) {
		
		if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);
		
		$query = "SELECT *, d.start, d.end FROM `billing` bi, booking bo, `driver_times` d WHERE bo.`booking_id`=d.`booking_id` AND bi.`bill_id` = ".$_GET["id"]." and bi.trip_id=bo.booking_id";
					
		$row = mysqli_fetch_assoc(mysqli_query($mysqli, $query));
$bid = $row["booking_id"];
 $l = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT pickup,destination FROM `maps_location` WHERE `booking_id` = '".$bid."' "));
		
		if(!empty($row['bill_id'])) {
			
			echo '<h1>Bill #'.$row['bill_id'].'</h1><hr>';
	
			$start_timestamp = strtotime($row["start"]);
			$end_timestamp = strtotime($row["end"]);

			$duration = $end_timestamp - $start_timestamp;

			echo '<h2 class="alert alert-info">'.$row["amount"].' LKR</h2>'; echo "<br>";
			
			echo '<div class="row"><div class="col">';

			echo '<h3>Pickme : '.$l["pickup"].'</h3>'; echo "<br>";
			
			echo '</div><div class="col">';

			echo '<h3>Destination : '.$l["destination"].'</h3></div></div>'; echo "<br>";
			
			echo '<h3>Duration : '.secondsToTime($duration).'</h3>'; echo "<br>";

			echo '<a href="#" class="btn btn-info d-print-none" onclick="window.print()">Print</a></div>';
		
		} else echo 'No such bill';
	
	} else echo 'Empty ID';
	
	echo '</div>';
	
	include 'footer.php';
?>
