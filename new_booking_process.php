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
				array_push($error,"Destination location is required");
		}
		
		
		$datetime = DateTime::createFromFormat('H:i', $time);
		$formatted_time = $datetime->format('H:i:s');
	
		if (count($error)== 0) {
				$query = "INSERT INTO booking (`user_id`, `date`, `time`, `pickup`, `destination`) VALUES ('".$_COOKIE["user"]."', '$date', '$formatted_time', '$pickup', '$destination')";

				$x = mysqli_query($sql, $query);

				if($x)
				{
					$distance_api = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".urlencode(trim($pickup))."&destinations=".urlencode(trim($destination))."&key=AIzaSyAVBiTDLtz6mIP1cEF-MFWClav9hPVJzYw";

					$distance_array = json_decode(file_get_contents($distance_api),true);
					
					$bookingid = mysqli_insert_id($sql);
					
					$pickupl = $distance_array['origin_addresses'][0]; 
					$destl = $distance_array['destination_addresses'][0]; 
					
					$query2 = "INSERT INTO `maps_location` (`booking_id`, `pickup`, `destination`, `distance`, `duration`)  VALUES ('".$bookingid."','".$pickupl."','".$destl."','".$distance_array["rows"][0]["elements"][0]["distance"]["value"]."','".$distance_array["rows"][0]["elements"][0]["duration"]["value"]."')";

					$b1 = mysqli_query($sql, $query2);
					
					$array["address"]["pickup"] = $pickupl;
					$array["address"]["destination"] = $destl;
					
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