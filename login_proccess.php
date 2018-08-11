<?php
include_once 'mysqli.php';
if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);

if((!empty($_POST)) OR (!empty($_GET))){

	if(isset($_POST['username'],$_POST['password'])) {
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$row = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM users WHERE username='".mysqli_real_escape_string($mysqli,$username)."' OR email='".mysqli_real_escape_string($mysqli,$username)."' AND password='".$password."'"));
		if(empty($row['password'])) $action = "Error logging in. The password is Empty."; elseif($password!==$row['password']) $action = "Error logging in. The password does not match.";
	}
}

include 'header.php';

echo '<div class="container">
	<h1>
		Login to the System
	</h1>
	<br>
	<form action="Login" method="post">
		<input type="text" class="form-control"
			name="username" placeholder="enter a username"> <br>
		<input type="password" class="form-control"
			name="password" placeholder="enter a password"> <br> <input
			type="submit" class="btn btn-primary btn-block" value="Login">
	</form>
	
<br>
<b>use the username "test" and password "test"" for the first login</b>
</div>';

include 'footer.php';

?>