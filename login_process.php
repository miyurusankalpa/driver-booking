<?php // Start the session
session_start();
header('Content-Type: application/json');

	include_once 'mysqli.php';
	if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);

	$array = array();

	if((!empty($_POST)) OR (!empty($_GET))){

		if(isset($_POST['username'],$_POST['password'])) {
			$username = $_POST['username'];
			$password = md5($_POST['password']);
			$row = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM users WHERE username='".mysqli_real_escape_string($mysqli,$username)."'"));
			
			if(empty($row['username'])) {
				$array["result"] = "error";
				$array["message"] = "No such user"; 
			} elseif($password!==$row['password']) {
				$array["result"] = "error";
				$array["message"] = "Wrong Password";
			} elseif($password==$row['password']) {
				
				setcookie("user", $row["user_id"], time()+3600);  /* expire in 1 hour */
				$_SESSION["user"] = $row["username"];
				
				//set cookies
				$array["result"] = "success";
				$array["group"] = ucfirst($row["group"]);
				$array["message"] = "Logged In";
				
				$_SESSION["group"] = $array["group"];
			}
		}
	} else {
		$array["result"] = "error";
		$array["message"] = "Empty data";
	}

	$json = json_encode($array);

	echo $json;

?>