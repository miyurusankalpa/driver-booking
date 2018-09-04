<?php

header('Content-Type: application/json');
include_once 'mysqli.php';
	
$error = array();

$sql =new mysqli($server, $user, $pass, $db);

if (isset($_POST['customer'])){

	$date = mysqli_real_escape_string($sql, $_POST['date']);
	$time = mysqli_real_escape_string($sql, $_POST['time']);
	$pickup = mysqli_real_escape_string($sql, $_POST['pickup']);
	$destination = mysqli_real_escape_string($sql, $_POST['destination']);
	
	
	
		if(empty($date)){
		
				array_push($error,"Date is required");
				
		}
		if(empty($pickup)){

				array_push($error,"Pickup location is required");
				
		}
		
		if(empty($destination)){
		
				array_push($error,"End point is required"));
		}
		
		if (count($error)== 0) {
			
				
				$query = "INSERT INTO booking (user_id,date, time, pickup, destination) VALUES ( '".$_COOKIE["user"]."', '$time', '$date', '$pickup', '$destination')";
				
				$x = mysqli_query($sql, $query);
				
				if(x == 1){
				
					$array["result"] = "success";
					$array["message"] = "Booking Successful";
					
			} else array_push($error, "Error adding date to the database. Try again");
		} else {
			$array["result"] = "error";
			$array["message"] = $error;
		}
	} else {
				$array["result"] = "error";
				$array["message"] = "Empty data";
	}
					

}
		
					
