<?php
	if(isset($_COOKIE["user"]))
	{
		setcookie("user", 0, time()-3600);  /* expire in -1 hour */
		header("Location: index.php");
	}
?>