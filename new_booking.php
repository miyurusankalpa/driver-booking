<?php
	include 'header.php';
?>
<div class="card card-body bg-light">
    <h2 class="text-center">Booking Details</h2>
	<hr>
     <form>	   
       <div class="form-group row">
          	<label class="col-sm-3 col-form-label">Select the date</label>
			<div class="col-sm-9">
				<input type="date" class="form-control" name="date">
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
				<input type="text" class="form-control" name="pickup">
			</div>  
	   </div>
	   
	   <div class="form-group row">
          	<label class="col-sm-3 col-form-label">Enter the destination</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" name="destination">
			</div>  
	   </div>
		   
          <div class="input-group">
          	   <button type="submit" id="submit" name="Register" class="btn btn-block btn-success">Submit</button>
          </div>
          <br><div id="booking_status"></div>
 </form></div>
 
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