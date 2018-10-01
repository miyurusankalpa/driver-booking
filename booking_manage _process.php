<?php

header('Content-Type: application/json');
include_once 'mysqli.php';
	
$error = array();

$sql =new mysqli($server, $user, $pass, $db);


if (isset($_POST['Accept_booking'])) {
	$bid = mysqli_real_escape_string($sql, $_POST['booking_id']);

	$query = "UPDATE booking SET status=1 WHERE user_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";

	$b = mysqli_query($sql, $query);
	
	if($b) 
	{ 
		$array["result"] = "success";
		$array["message"] = "Booking done.";
	} else {
		$array["result"] = "error";
		$array["message"] = "Booking failed.";
	}

	goto output;
}

if (isset($_POST['on_the_way'])) {
	$bid = mysqli_real_escape_string($sql, $_POST['booking_id']);

	$query = "UPDATE booking SET status=2 WHERE user_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";

	$b = mysqli_query($sql, $query);
	
	if($b) 
	{ 
		$array["result"] = "success";
		$array["message"] = "on the way.";
	} else {
		$array["result"] = "error";
		$array["message"] = "success.";
	}

	goto output;
}


if (isset($_POST['manage'])) {
	
	$date = mysqli_real_escape_string($sql, $_POST['date']);
	
	$pickup_time = mysqli_real_escape_string($sql, $_POST['pickup']);
	$end_time = mysqli_real_escape_string($sql, $_POST['time']);
	$trip_mileage = mysqli_real_escape_string($sql, $_POST['destination']);
	
		if(empty($date)){
				array_push($error,"Date is required");
		}
		
		if(empty($pickup_time)){
				array_push($error,"Pickup Time is required");
		}
		
		if(empty($end_time)){
				array_push($error,"End time is required");
		}
		
		if(empty($trip_mileage)){
				array_push($error,"Mileage is required");
		}
		
		
		$datetime = DateTime::createFromFormat('H:i', $time);
		$formatted_time = $datetime->format('H:i:s');
	
		if (count($error)== 0) {
				$query = "INSERT INTO booking (`user_id`, `date`, `time`, `pickup`, `destination`) VALUES ('".$_COOKIE["user"]."', '$date', '$formatted_time', '$pickup', '$destination')";

				$x = mysqli_query($sql, $query);