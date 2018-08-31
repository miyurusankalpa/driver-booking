<?php //todo no json login

header('Content-Type: application/json');
include_once 'mysqli.php';
if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);

$array = array();

if((!empty($_POST)) OR (!empty($_GET))){

	if(isset($_POST['username'],$_POST['password'])) {
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$row = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM users WHERE username='".mysqli_real_escape_string($mysqli,$username)."'"));
		
		if(empty($row['password'])) {
			$array["result"] = "error";
			$array["message"] = "No such user"; 
		} elseif($password!==$row['password']) {
			$array["result"] = "error";
			$array["message"] = "Wrong Password";
		} elseif($password==$row['password']) {
			setcookie("user", $username, time()+3600);  /* expire in 1 hour */
			
			//set cookies
			$array["result"] = "success";
			$array["message"] = "Logged In";
		}

	}
} else {
	$array["result"] = "error";
	$array["message"] = "Empty data";
}

$json = json_encode($array);

echo $json;

?>