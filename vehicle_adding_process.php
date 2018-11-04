<?php

	header('Content-Type: application/json');

	include_once 'mysqli.php';
	$error = array(); 	$array = array();
	
	// connecting to database
	$sql = new mysqli($server, $user, $pass, $db);
	if (isset($_POST['vehicle'])) {

		$VehicleType = mysqli_real_escape_string($sql, $_POST['Vtype']);
		$Brand = mysqli_real_escape_string($sql, $_POST['brand']);
		$VehicleNo = mysqli_real_escape_string($sql, $_POST['Vno']);
		$colour = mysqli_real_escape_string($sql, $_POST['colour']);
		$mobileNo = mysqli_real_escape_string($sql, $_POST['mobileNo']);
		//print_r($_POST);
		
		if(empty($VehicleType)) {
				array_push($error, "Vehicle type is required");
		}
		if(empty($Brand)) {
				array_push($error, "Vehicle brand is required");
		}
		
		if(empty($VehicleNo) ) {
				array_push($error, "Vehicle reistration number is required"); //error msg username
		}
		
		if(empty($colour)) {
				array_push($error, "Colour of the vehicle is required");  //error msg password
		}
		
		if(empty($password)) {
				array_push($error, "Password is required");
		}
		
		if(empty($conpassword)) {
				array_push($error, "Confirm password is required");
		}
		if($password != $conpassword) {
				array_push($error, "Confim passwords do not match. Try again");
		}
		if(count($error) == 0) {
				$encryptpass = md5($password); //encryption
				$query = "INSERT INTO users (`firstname`, `lastname`, `username`, `email`, `password`, `mobileno`, `group`) VALUES ('$Firstname', '$Lastname', '$username', '$email', '$encryptpass', '$mobileNo','Customer')";
				
				$x = mysqli_query($sql, $query);
				if($x)
				{
					$array["result"] = "success";
					$array["message"] = "Registration Successful. Please use the sign in link to login.";
					goto output;
				} else {
					//echo mysqli_error($sql);
					array_push($error, "Error adding date to the database. Try again");
				}
			}			
	} else array_push($error, "Empty Data.");
	$array["result"] = "error";
	$array["message"] = $error;
	
output:	
	$json = json_encode($array);
	echo $json;
?>