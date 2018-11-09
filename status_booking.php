<?php
	include 'header.php'; 	
	
	if(!isset($_COOKIE["user"]))
	{
		echo '<div class="container">
		<h2 class="alert alert-danger">You have to login to access this page</h2><br>
		</div>';
		include 'footer.php'; die;
	}
	
	include_once 'mysqli.php';

	echo '<div class="card card-body bg-light text-center">';

	if(isset($_GET["id"])) {
		
		if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);
		
		$query = "SELECT b.*, m.pickup as pickup_l, m.destination as dest_l, m.distance, m.duration FROM `booking` b, `maps_location` m WHERE b.`booking_id` = ".$_GET["id"]." AND b.`booking_id`=m.`booking_id`";
					
		$row = mysqli_fetch_assoc(mysqli_query($mysqli, $query));
		
		if(!empty($row['booking_id'])) {
			
			echo '<h1>Booking #'.$row['booking_id'].'</h1><hr>';
	
			if(($_SESSION["group"]=="Driver") AND ($row['status']<8)) {
				echo '<div id="msg_status"></div><div class="row"><div class="col"><h2>Manage Booking</h2></div>
				<div class="col"> 
				<div class="btn-group text-center" role="group">';
				if($row['status']<3) echo '<a href="#" id="accept_btn" data-booking-id="'.$row['booking_id'].'" class="btn btn-secondary btn-warning manage">Accept Booking</a>';
				if($row['status']<4) echo '<a href="#" id="on_the_way_btn" data-booking-id="'.$row['booking_id'].'" class="btn btn-secondary btn-info manage">On the Way</a>';
				if($row['status']<5) echo '<a href="#" id="start_btn" data-booking-id="'.$row['booking_id'].'" class="btn btn-secondary btn-info manage">Mark as started</a>';
				if($row['status']<6) echo '<a href="#" id="complete_btn" data-booking-id="'.$row['booking_id'].'" class="btn btn-secondary btn-success manage">Mark as complete</a>';
				if($row['status']==6) echo '<a href="#" id="make_bill_btn" data-booking-id="'.$row['booking_id'].'" class="btn btn-secondary btn-success manage">Make bill</a>';
				if($row['status']==7) echo '<a href="#" id="bill_btn" data-booking-id="'.$row['booking_id'].'" class="btn btn-secondary btn-success manage">Payment done</a>';
				echo'</div>
			</div></div><hr>';
			}
			
			echo '<div class="row"><div class="col">';

			$pickup =  $row["pickup"];
			$dest =  $row["destination"];
			
			echo '<b>Pickup </b><br>'.$row["pickup_l"]; echo "<br>";
			echo '<b>Destination </b><br>'.$row["dest_l"]; echo "<br><br>";
			
			echo '<b>Estimated duration </b><br>'.secondsToTime($row["duration"]); echo "<br>";
			echo '<b>Estimated distance </b><br>'.distance2readable($row["distance"]); echo "<br><br>";
			
			echo '<b>Booking Status </b><br><div class="badge badge-'.booking_status2text($row['status'],0).'">'.booking_status2text($row['status'],1).'</div>'; echo "<br>";
			echo '<b>Booked </b><br>'.time_elapsed($row["booking_time"]); echo "<br><br>";
			
			echo '<b>Time to pickup </b><br>'.time_elapsed($row["date"].$row["time"]); echo "<br>";
			echo '<b>Driver </b><br>'.get_fullname($row["driver_id"]); echo "<br>";
			
			echo '</div><div class="col">';
			
			//echo '<button class="btn btn-info">Load Map</button>';
			
			echo '<div class="embed-responsive embed-responsive-16by9">
			<iframe src="https://www.google.com/maps/embed/v1/directions?key=AIzaSyAVBiTDLtz6mIP1cEF-MFWClav9hPVJzYw&origin='.urlencode($pickup).'&destination='.urlencode($dest).'&avoid=highways" width="896" height="504" frameborder="0" >
			</iframe></div>';
			
			echo '</div></div>';
		
		} else echo 'No such Booking';
	
	} else echo 'Empty ID';
	
	echo '</div>';

?>

<script type="text/javascript">
j(document).ready(function () {
    j('.manage').click(function (e) {

	e.preventDefault();

	var bid = j(this).data("booking-id");
	var btnid = j(this).attr("id");
	
	j.ajax({
	   type: "POST",
	   dataType: 'json',
	   url: "booking_manage_process.php",
	   data: 'booking_id='+ bid +'&'+btnid+'=true&json=true',
	   cache: false,
	   success: function(data){
				if(data.result=="error"){
					j("#msg_status").html('<div class="alert alert-warning">'+ data.message +'</div>').fadeIn("slow").delay(5000).fadeOut("slow");
				}
				if(data.result=="success"){
					j("#msg_status").html('<div class="alert alert-success">'+ data.message +'</div>').fadeIn("slow").delay(5000).fadeOut("slow");
					j(this).prop('disabled', true);;
				}
			},
		error: function(jqXHR,error, errorThrown){
			j("#msg_status").html('<div class="alert alert-danger">OH! :O There was a unexpected error :(</div>').fadeIn("slow").delay(5000).fadeOut("slow");
			j('input').attr('disabled', false);
		}
		});
	});
});
</script>

<?php
	include 'footer.php';
?>