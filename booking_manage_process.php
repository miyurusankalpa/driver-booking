<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

header('Content-Type: application/json');
include_once 'mysqli.php';
include_once 'functions.php';
include_once 'mail.php';
include_once 'sms.php';

$error = array();

$sql =new mysqli($server, $user, $pass, $db);

$bid = mysqli_real_escape_string($sql, $_POST['booking_id']);
$r['booking_id']= $bid;
$booking_id = $bid;

if (isset($_POST['accept_btn'])) {

	$query = "UPDATE booking SET status='3' WHERE driver_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";

	$b = mysqli_query($sql, $query);
	
	if($b) 
	{ 
		$r = mysqli_fetch_assoc(mysqli_query($sql, "SELECT b.*,u.email, u.username FROM `booking` b, users u WHERE `booking_id` = '".$bid."'  AND u.user_id=b.user_id"));
		$d = mysqli_fetch_assoc(mysqli_query($sql, "SELECT u.* FROM `booking` b, users u WHERE `booking_id` = '".$bid."'  AND u.user_id=b.driver_id"));
		$l = mysqli_fetch_assoc(mysqli_query($sql, "SELECT pickup,destination FROM `maps_location` WHERE `booking_id` = '".$booking_id."' "));
		
		$addii = "Pickup : ".$l['pickup']."<br>Destination : ".$l['destination']." <br>Driver : ".$d['firstname']." ".$d['lastname']."<br>Driver mobile number : ".$d['mobileno']." <br>Status : ".booking_status2text($r['status'],1)."";
		sendmailbymailgun($r['email'],$r['username'],"Bookings","bookings@chauffeurlk.com","Booking #".$bid." Status ".booking_status2text($r['status'],1)."",booking_mail($r['firstname']." ".$r['lastname'],$bid,$addii),"admin@chauffeurlk.com");
						
		$array["result"] = "success";
		$array["message"] = "Booking marked as accepted.";
	} else {
		$array["result"] = "error";
		$array["message"] = "Booking change failed.";
	}

	goto output;
}

if (isset($_POST['on_the_way_btn'])) {

	$query = "UPDATE booking SET status='4' WHERE driver_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";

	$b = mysqli_query($sql, $query);
	
	if($b) 
	{ 
		$r = mysqli_fetch_assoc(mysqli_query($sql, "SELECT b.*,u.email, u.username FROM `booking` b, users u WHERE `booking_id` = '".$bid."'  AND u.user_id=b.user_id"));
		$l = mysqli_fetch_assoc(mysqli_query($sql, "SELECT pickup,destination FROM `maps_location` WHERE `booking_id` = '".$booking_id."' "));

		$addii = "Pickup : ".$l['pickup']."<br>Destination : ".$l['destination']." <br>Status : ".booking_status2text($r['status'],1)."";
		sendmailbymailgun($r['email'],$r['username'],"Bookings","bookings@chauffeurlk.com","Booking #".$bid." Status ".booking_status2text($r['status'],1)."",booking_mail($r['firstname']." ".$r['lastname'],$bid,$addii),"admin@chauffeurlk.com");
		
		include_once 'sms.php';
		sendsms($r['mobileno'],"Driver on the way, Time : ".$r["date"]." ".$r["time"]."");
		
		$array["result"] = "success";
		$array["message"] = "Booking marked as on the way.";
	} else {
		$array["result"] = "error";
		$array["message"] = "Booking change failed.";
	}

	goto output;
}

if (isset($_POST['start_btn'])) {

	$query = "UPDATE booking SET status='5' WHERE driver_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";
	$query2 = "UPDATE driver_times SET start=NOW() WHERE driver_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";

	$b = mysqli_query($sql, $query);
	$c = mysqli_query($sql, $query2);
	
	if($b) 
	{ 
		$r = mysqli_fetch_assoc(mysqli_query($sql, "SELECT b.*,u.email, u.username FROM `booking` b, users u WHERE `booking_id` = '".$bid."'  AND u.user_id=b.user_id"));
$l = mysqli_fetch_assoc(mysqli_query($sql, "SELECT pickup,destination FROM `maps_location` WHERE `booking_id` = '".$booking_id."' "));

		$addii = "Pickup : ".$l['pickup']."<br>Destination : ".$l['destination']." <br>Status : ".booking_status2text($r['status'],1)."";
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

	$query = "UPDATE booking SET status='6' WHERE driver_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";
	$query2 = "UPDATE driver_times SET end=NOW() WHERE driver_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";

	$b = mysqli_query($sql, $query);
	$c = mysqli_query($sql, $query2);
	
	if($b) 
	{ 
		$r = mysqli_fetch_assoc(mysqli_query($sql, "SELECT b.*,u.email, u.username FROM `booking` b, users u WHERE `booking_id` = '".$bid."'  AND u.user_id=b.user_id"));
$l = mysqli_fetch_assoc(mysqli_query($sql, "SELECT pickup,destination FROM `maps_location` WHERE `booking_id` = '".$booking_id."' "));

		$addii = "Pickup : ".$l['pickup']."<br>Destination : ".$l['destination']." <br>Status : ".booking_status2text($r['status'],1)."";
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
if (isset($_POST['make_bill_btn'])) {
	file_get_contents("http://chauffeurlk.com/make_bill.php?id=".$_POST['booking_id']);
	$array["result"] = "success";
	$array["message"] = "Bill has been created.";
}
if (isset($_POST['bill_btn'])) {

	$query = "UPDATE booking SET status='8' WHERE driver_id='".$_COOKIE["user"]."' AND booking_id='".$bid."'";
	$query2 = "UPDATE billing SET status='1' WHERE trip_id='".$bid."'";

	$b = mysqli_query($sql, $query);
	$c = mysqli_query($sql, $query2);
	
	if($b) 
	{ 
		include_once 'mail.php';
		$b = mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `billing` b, users u WHERE `trip_id` = '".$booking_id."' AND u.user_id=b.uid"));

		$addii = "Bill Amount ".$b['amount']." LKR<br>Status : ".booking_status2text(8,1)."";
		sendmailbymailgun($b['email'],$b['username'],"Billings","billings@chauffeurlk.com","Bill #".$b['bill_id']." Status ".booking_status2text(8,1)."",billing_mail($b['firstname']." ".$b['lastname'],$b['bill_id'],$addii),"admin@chauffeurlk.com");
		
		$array["result"] = "success";
		$array["message"] = "Bill marked as payed.";
	} else {
		$array["result"] = "error";
		$array["message"] = "Bill marked as payed failed.";
	}

	goto output;
}				
	
output:	

	$json = json_encode($array);
	echo $json;
