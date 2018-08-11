<?php
include 'header.php';

echo '<div class="container">
	<h1>
		Login to the System
	</h1>
	<br>
	<form action="login_proccess.php" method="post">
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