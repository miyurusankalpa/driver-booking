<?php

include_once 'mysqli.php';

// connecting to database
$sql = new mysqli($server, $user, $pass, $db);

//get booking details
$query = "SELECT b.*, m.distance, m.duration FROM `booking` b, `maps_location` m WHERE b.`booking_id` = ".$_GET["id"]." AND b.`booking_id`=m.`booking_id` LIMIT 1";

$row = mysqli_fetch_assoc(mysqli_query($sql, $query));

//check if driver is already assgned
if($row["driver_id"]!="0") die("1");
	
echo $pickup_timestamp = strtotime($row["date"].$row["time"]);

die("2");

//get a active driver list
$query = "SELECT * FROM `users` WHERE `group` = 'Driver' AND `status` = 1";

$result = mysqli_query($sql, $query);

// output data of each row
while($row = mysqli_fetch_assoc($result)) {
	//check if the driver is avaible
	$query = "SELECT * FROM `driver_times` WHERE `driver_id` = '".$row['driver_id']."' AND `start` < '".$pickup_timestamp."' AND `end` > '".$pickup_timestamp."' ";

	
	$result = mysqli_query($sql, $query);
	
}

?>