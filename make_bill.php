<?php
$booking_id = $_GET["id"];

include_once 'mysqli.php';
include_once 'prices_data.php';

// connecting to database
$sql = new mysqli($server, $user, $pass, $db);

//get completed booking details
$query = "SELECT b.*, d.start, d.end FROM `booking` b, `driver_times` d WHERE b.`booking_id`=d.`booking_id` AND b.booking_id='".$booking_id ."' AND b.status=6 LIMIT 1";

$result = mysqli_query($sql, $query);

if(!$result) die("Error");

$row = mysqli_fetch_assoc($result);

if($row["status"]!=="6") die("Invalid");

$start_timestamp = strtotime($row["start"]);
$end_timestamp = strtotime($row["end"]);

$duration = $end_timestamp - $start_timestamp;
$mins = $duration/60;

$discount=0;
$price = ($price_data["rs_start"] + ($mins*$price_data["rs_per_min"])) - $discount;

$query = "INSERT INTO `billing`(`trip_id`, `amount`, `discount`, `status`, `uid`) VALUES ( '".$booking_id."','".$price."','".$discount."','0','".$row["user_id"]."')";

$result = mysqli_query($sql, $query);

$query = "UPDATE `booking` SET `status`='7'  WHERE `booking_id`='".$booking_id."'";

$result = mysqli_query($sql, $query);

die($price);
?>