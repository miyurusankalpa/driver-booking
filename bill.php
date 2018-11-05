<?php
	include 'header.php'; 	
	include_once 'mysqli.php';

	echo '<div class="card card-body bg-light text-center">';

	if(isset($_GET["id"])) {
		
		if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);
		
		$query = "SELECT * FROM `billing` WHERE `bill_id` = ".$_GET["id"]."";
					
		$row = mysqli_fetch_assoc(mysqli_query($mysqli, $query));
		
		if(!empty($row['bill_id'])) {
			
			echo '<h1>Bill #'.$row['bill_id'].'</h1><hr>';
	
			echo '<div class="row"><div class="col">';
	
			echo '<h2>'.$row["amount"].' LKR</h2>'; echo "<br>";
				
			echo '</div>';
		
		} else echo 'No such Booking';
	
	} else echo 'Empty ID';
	
	echo '</div>';
	
	include 'footer.php';
?>