<?php  //inception
header('Content-Type: application/json');

	include_once 'mysqli.php';

	$error = array(); 	$array = array();
	
	// connecting to database
	$sql = new mysqli($server, $user, $pass, $db);

	if (isset($_POST['register'])) {

		$Firstname = mysqli_real_escape_string($sql, $_POST['Firstname']);
		$Lastname = mysqli_real_escape_string($sql, $_POST['Lastname']);
		$username = mysqli_real_escape_string($sql, $_POST['username']);
		$email = mysqli_real_escape_string($sql, $_POST['Email']);
		$password = mysqli_real_escape_string($sql, $_POST['password']);
		$conpassword = mysqli_real_escape_string($sql, $_POST['Conpassword']);
		$mobileNo = mysqli_real_escape_string($sql, $_POST['mobileNo']);

		//print_r($_POST);
		
		if(empty($Firstname)) {
				array_push($error, "Firstname is required");
		}

		if(empty($Lastname)) {
				array_push($error, "Lastname is required");
		}
		
		if(empty($username) ) {
				array_push($error, "Username is required"); //error msg username
		}
		
		if(empty($email)) {
				array_push($error, "Email is required");  //error msg password
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

		if(count($error)== 0) {
				$encryptpass = md5($password); //encryption
				$query = "INSERT INTO users (firstname, lastname, username, email, password, mobileno) VALUES ('$Firstname', '$Lastname', '$username', '$email', '$encryptpass', '$mobileNo')";
				
				$x = mysqli_query($sql, $query);
			if($x){
				$array["result"] = "success";
				$array["message"] = "Registration Successful";
			} else array_push($error, "Error adding date to the database. Try again");
			
		} else {
			$array["result"] = "error";
			$array["message"] = $error;
		}
	} else {
				$array["result"] = "error";
				$array["message"] = "Empty data";
	}

	$json = json_encode($array);

	echo $json;

?>