<?php
$booking_id = $_GET["id"];

include_once 'mysqli.php';
include_once 'prices_data.php';
include_once 'functions.php';

// connecting to database
$sql = new mysqli($server, $user, $pass, $db);

//get completed booking details
$query = "SELECT b.*, d.start, d.end FROM `booking` b, `driver_times` d WHERE b.`booking_id`=d.`booking_id` AND b.booking_id='".$booking_id ."' AND b.status=6 LIMIT 1";

$result = mysqli_query($sql, $query);

if(!$result) die("Error");

$row = mysqli_fetch_assoc($result);

if($row["status"]!=6) die("Invalid");

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

		include_once 'mail.php';
		$b = mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `billing` b, users u WHERE `trip_id` = '".$booking_id."' AND u.user_id=b.uid"));
		$d = mysqli_fetch_assoc(mysqli_query($sql, "SELECT u.* FROM `booking` b, users u WHERE `booking_id` = '".$booking_id."'  AND u.user_id=b.driver_id"));

		$addii = "Bill Amount ".$b['amount']." LKR<br>Status : ".booking_status2text(7,1)."";
		sendmailbymailgun($b['email'],$b['username'],"Billings","billings@chauffeurlk.com","Bill #".$b['bill_id']." Status ".booking_status2text(7,1)."",billing_mail($b['firstname']." ".$b['lastname'],$b['bill_id'],$addii),"admin@chauffeurlk.com",$d['email']);
		
die($price);
?>