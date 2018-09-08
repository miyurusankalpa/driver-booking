<?php

header('Content-Type: application/json');
include_once 'mysqli.php';
	
$error = array();

$sql =new mysqli($server, $user, $pass, $db);

if (isset($_POST['customer'])) {
	
	$date = mysqli_real_escape_string($sql, $_POST['date']);
	$time = mysqli_real_escape_string($sql, $_POST['time']);
	$pickup = mysqli_real_escape_string($sql, $_POST['pickup']);
	$destination = mysqli_real_escape_string($sql, $_POST['destination']);
	
		if(empty($date)){
				array_push($error,"Date is required");
		}
		
		if(empty($time)){
				array_push($error,"Time is required");
		}
		
		if(empty($pickup)){
				array_push($error,"Pickup location is required");
		}
		
		if(empty($destination)){
				array_push($error,"End point is required");
		}
		
		
		$datetime = DateTime::createFromFormat('H:i', $time);
		$formatted_time = $datetime->format('H:i:s');
	
		if (count($error)== 0) {
				$query = "INSERT INTO booking (`user_id`, `date`, `time`, `pickup`, `destination`) VALUES ('".$_COOKIE["user"]."', '$date', '$formatted_time', '$pickup', '$destination')";
				
				$x = mysqli_query($sql, $query);

				if($x)
				{
					$array["result"] = "success";
					$array["message"] = "Booking Successful.";
					goto output;
				} else {
					echo mysqli_error($sql);
					array_push($error, "Error adding data to the database. Try again.");
				}
			}
			
	} else array_push($error, "Empty Data.");

	$array["result"] = "error";
	$array["message"] = $error;
	
output:	

	$json = json_encode($array);
	echo $json;
	
?>