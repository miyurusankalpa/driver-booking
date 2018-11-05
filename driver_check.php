<?php

//$booking_id = $_GET["id"];

include_once 'mysqli.php';

// connecting to database
$sql = new mysqli($server, $user, $pass, $db);

//get booking details
$query = "SELECT b.*, m.distance, m.duration FROM `booking` b, `maps_location` m WHERE b.status=0 AND b.`booking_id`=m.`booking_id` LIMIT 1";

$row = mysqli_fetch_assoc(mysqli_query($sql, $query));

//check if driver is already assgned
if($row["driver_id"]!=="0") die("Driver Assigned");

$pickup_timestamp = strtotime($row["date"].$row["time"]);
$end_timestamp = $pickup_timestamp+$row["duration"];

//die("2");

//get a active driver list
$query = "SELECT * FROM `users` WHERE `group` = 'Driver' AND `status` = 1";

$result = mysqli_query($sql, $query);

// output data of each row
while($row = mysqli_fetch_assoc($result)) {
	$driverid = $row["user_id"];
	
	//check if the driver is avaible
	$result2 = mysqli_query($sql, "SELECT * FROM `driver_times` WHERE `driver_id` = '".$driverid."' AND `start` <= FROM_UNIXTIME(".$pickup_timestamp.") AND `end` >= FROM_UNIXTIME(".$end_timestamp.") ");
	
	if(mysqli_num_rows($result2) == 0) {
		$query = "INSERT INTO `driver_times`(`driver_id`, `start`, `end`, `booking_id`) VALUES ( '".$driverid."',FROM_UNIXTIME(".$pickup_timestamp."),FROM_UNIXTIME(".$end_timestamp."),'".$booking_id."')";
	
		$result = mysqli_query($sql, $query);
		
		$query = "UPDATE `booking` SET `driver_id`='".$driverid."',`status`='1' WHERE `booking_id`='".$booking_id."'";
	
		$result = mysqli_query($sql, $query);
		die("Success");
	}
}

?>