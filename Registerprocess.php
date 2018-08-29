<?php  

	$error = array();
	// connecting to database
	$db = mysqli_connect('localhost', 'system', 'gdfgdf');

	if (isset($_POST['register'])) {

		$Firstname = mysql_real_escape_string($_POST['Firstname']);
		$Lastname = mysql_real_escape_string($_POST['Lastname']);
		$username = mysql_real_escape_string($_POST['username']);
		$Email = mysql_real_escape_string($_POST['Email']);
		$password = mysql_real_escape_string($_POST['password']);
		$Conpassword = mysql_real_escape_string($_POST['Conpassword']);
		$mobileNo = mysql_real_escape_string($_POST['mobileNo']);

		if (empty($Firstname)) {
			
				array_push($error, "Firstname is required");
		}

		if (empty($Lastname)) {

				array_push($error, "Lastname is required");
		}
		if (empty($username) ) {
				
				array_push($error, "Username is required"); //error msg username
		}
		if (empty($Email)) {
				
				array_push($error, "Email is required");  //error msg password
		}
		if (empty($password)) {
				
				array_push($error, "password is required");
		
		}if (empty($Conpassword)) {
			
				array_push($error, "confirm password is required");
		}

		if ($password != Conpassword) {
			
				array_push($error, "passwords do not match.Try again");
		}

		if (count($error)== 0) {
			
				//$encryptpass = md5($password);//encryption
				$sql = "INSERT INTO user (Firstname, Lastname, username, email, password, mobileNo) VALUES ('$Firstname', '$Lastname', '$username', '$Email', '$password', '$mobileNo')";
				
				mysqli_query($db, $sql);
		}
		

		$json = json_encode($error);

		echo $json;
	}

