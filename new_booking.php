<?php
	include 'header.php';
	
	if(!isset($_COOKIE["user"]))
	{
		echo '<div class="container">
		<h2 class="alert alert-danger">You have to login to access this page</h2><br>
		</div>';
		include 'footer.php'; die;
	} else if(@$_SESSION["group"]!=="Customer") {
		echo '<div class="container">
		<h2 class="alert alert-danger">You are no authorized to access this page</h2><br>
		</div>';;
		include 'footer.php'; die;
	}
?>
<div class="card card-body bg-light">

    <h2 class="text-center">Book New Trip</h2>
	<hr>
     <form>	   
       <div class="form-group row">
          	<label class="col-sm-3 col-form-label">Select the date</label>
			<div class="col-sm-9">
				<input type="date" class="form-control" name="date" min="<?php echo date('Y-m-d',strtotime("+1 day")); ?>">
			</div>  
	   </div>
	   
	   <div class="form-group row">
          	<label class="col-sm-3 col-form-label">Select the time</label>
			<div class="col-sm-9">
				<input type="time" class="form-control" name="time">
			</div>  
	   </div>
	   
	   <div class="form-group row">
          	<label class="col-sm-3 col-form-label">Enter the pickup location</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="pickt" name="pickup">
			</div>  
	   </div>
	   
	   <div class="form-group row">
          	<label class="col-sm-3 col-form-label">Enter the destination</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="destt" name="destination">
			</div>  
	   </div>
	   <div class="btn btn-block btn-primary" id="mapbtn">pick pickup and destination on map</div>

	   
	   <div id="googleMap" style="width:100%;height:300px;display:none;">test</div>

	<script>
	j( "#mapbtn" ).click(function() {
	  j( "div#googleMap" ).show( "slow" );
	});
		
	function myMap() {
	var mapProp= {
		center:new google.maps.LatLng(6.914600, 79.973055),
		zoom:10,
	};
	
	var click = 0;
	
	var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

	google.maps.event.addListener(map, 'click', function(event) {
		click++;
		console.log(click);
		
		if(click==1){
			//1 st click
			j("input#pickt").val(event.latLng.lat() + ", " + event.latLng.lng()).attr("disabled", "disabled");
			j("#booking_status").html('<div class="alert alert-info">Pickup location added</div>').fadeIn("slow").delay(1000).fadeOut("slow");
		}
		
		if(click==2){
			//2 st click
			j("input#destt").val(event.latLng.lat() + ", " + event.latLng.lng()).attr("disabled", "disabled");
			j("#booking_status").html('<div class="alert alert-info">Destination location added</div>').fadeIn("slow").delay(1000).fadeOut("slow");
			
			j("div#googleMap").delay(100).fadeOut("slow");
			j("div#mapbtn").delay(500).hide();
		}
		
	});

	}
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVBiTDLtz6mIP1cEF-MFWClav9hPVJzYw&origin&callback=myMap"></script>
	   </br> 
          <div class="input-group">
          	   <button type="submit" id="submit" name="Register" class="btn btn-block btn-success">Book new trip</button>
          </div>
          <br><div id="booking_status" class="text-center"></div>
 </form>
 <a href="/customer.php" class="btn btn-info">Back to dashboard</a>
 </div>
 
 <script type="text/javascript">
j(document).ready(function () {
    j('#submit').click(function (e) {

	e.preventDefault();

	if(!j(this).closest('form')[0].checkValidity()){
		return false;
	} 
	
	var date = j("input[name=date]").val();
	var time = j("input[name=time]").val();
	var pickup = j("input[name=pickup]").val();
	var destination = j("input[name=destination]").val();

	j('input').attr('disabled', true);

	j.ajax({
	   type: "POST",
	   dataType: 'json',
	   url: "new_booking_process.php",
	   data: 'date='+ date +'&time='+ time +'&pickup='+ pickup +'&destination='+ destination +'&customer=<?php echo $_COOKIE['user']; ?>&json=true',
	   cache: false,
	   success: function(data){
				if(data.result=="error"){
					j("#booking_status").html('<div class="alert alert-warning">'+ data.message +'</div>').fadeIn("slow");
					j('input').attr('disabled', false);
				}
				if(data.result=="success"){
					j("#booking_status").html('<div class="alert alert-success">'+ data.message +'</div>').fadeIn("slow");
					j("input#pickt").val(data.address.pickup);
					j("input#destt").val(data.address.destination);
					j('#submit').attr('disabled', true);
				}
			},
		error: function(jqXHR,error, errorThrown){
			j("#booking_status").html('<div class="alert alert-danger">OH! :O There was a unexpected error :(</div>').fadeIn("slow");
			j('input').attr('disabled', false);
		}
		});
	});
});
</script>
<?php
	include 'footer.php';
?>