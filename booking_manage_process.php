<?php

header('Content-Type: application/json');
include_once 'mysqli.php';
include_once 'functions.php';

$error = array();

$sql =new mysqli($server, $user, $pass, $db);

$bid = mysqli_real_escape_string($sql, $_POST['booking_id']);

if (isset($_POST['accept_btn'])) {

	$query = "UPDATE booking SET status='2' WHERE driver_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";

	$b = mysqli_query($sql, $query);
	
	if($b) 
	{ 

		$r = mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `booking` b, users u WHERE `booking_id` = '".$bid."'  AND u.user_id=b.user_id"));

		$addii = "Pickup : ".$r['pickup']."<br>Destination : ".$r['destination']." <br>Status : ".booking_status2text($r['status'],1)."";
		sendmailbymailgun($r['email'],$r['username'],"Bookings","bookings@chauffeurlk.com","Booking #".$r['booking_id']." Status ".booking_status2text($r['status'],1)."",booking_mail($r['firstname']." ".$r['lastname'],$r['booking_id'],$addii),"admin@chauffeurlk.com");
						
		$array["result"] = "success";
		$array["message"] = "Booking marked as accepted.";
	} else {
		$array["result"] = "error";
		$array["message"] = "Booking change failed.";
	}

	goto output;
}

if (isset($_POST['on_the_way_btn'])) {

	$query = "UPDATE booking SET status='3' WHERE driver_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";

	$b = mysqli_query($sql, $query);
	
	if($b) 
	{ 
		$r = mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `booking` b, users u WHERE `booking_id` = '".$bid."'  AND u.user_id=b.user_id"));

		$addii = "Pickup : ".$r['pickup']."<br>Destination : ".$r['destination']." <br>Status : ".booking_status2text($r['status'],1)."";
		sendmailbymailgun($r['email'],$r['username'],"Bookings","bookings@chauffeurlk.com","Booking #".$r['booking_id']." Status ".booking_status2text($r['status'],1)."",booking_mail($r['firstname']." ".$r['lastname'],$r['booking_id'],$addii),"admin@chauffeurlk.com");
		//sms
		
		$array["result"] = "success";
		$array["message"] = "Booking marked as on the way.";
	} else {
		$array["result"] = "error";
		$array["message"] = "Booking change failed.";
	}

	goto output;
}

if (isset($_POST['start_btn'])) {

	$query = "UPDATE booking SET status='3' WHERE driver_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";
	$query2 = "UPDATE driver_times SET start=NOW() WHERE driver_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";

	$b = mysqli_query($sql, $query);
	$c = mysqli_query($sql, $query2);
	
	if($b) 
	{ 
		$r = mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `booking` b, users u WHERE `booking_id` = '".$bid."'  AND u.user_id=b.user_id"));

		$addii = "Pickup : ".$r['pickup']."<br>Destination : ".$r['destination']." <br>Status : ".booking_status2text($r['status'],1)."";
		sendmailbymailgun($r['email'],$r['username'],"Bookings","bookings@chauffeurlk.com","Booking #".$r['booking_id']." Status ".booking_status2text($r['status'],1)."",booking_mail($r['firstname']." ".$r['lastname'],$r['booking_id'],$addii),"admin@chauffeurlk.com");
		
		$array["result"] = "success";
		$array["message"] = "Booking marked as started.";
	} else {
		$array["result"] = "error";
		$array["message"] = "Booking change failed.";
	}

	goto output;
}

if (isset($_POST['complete_btn'])) {

	$query = "UPDATE booking SET status='3' WHERE driver_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";
	$query2 = "UPDATE driver_times SET end=NOW() WHERE driver_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";

	$b = mysqli_query($sql, $query);
	$c = mysqli_query($sql, $query2);
	
	if($b) 
	{ 
		$r = mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `booking` b, users u WHERE `booking_id` = '".$bid."'  AND u.user_id=b.user_id"));

		$addii = "Pickup : ".$r['pickup']."<br>Destination : ".$r['destination']." <br>Status : ".booking_status2text($r['status'],1)."";
		sendmailbymailgun($r['email'],$r['username'],"Bookings","bookings@chauffeurlk.com","Booking #".$r['booking_id']." Status ".booking_status2text($r['status'],1)."",booking_mail($r['firstname']." ".$r['lastname'],$r['booking_id'],$addii),"admin@chauffeurlk.com");
		//diveremail
		
		$array["result"] = "success";
		$array["message"] = "Booking marked as complete.";
	} else {
		$array["result"] = "error";
		$array["message"] = "Booking change failed.";
	}

	goto output;
}
				
	
output:	

	$json = json_encode($array);
	echo $json;