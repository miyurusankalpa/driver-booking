<?php
	include 'header.php';
?>
<div class="card card-body bg-light">
    <h2 class="text-center">Booking Details</h2>
	<hr>
     <form method="post">	   
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
          	   <button type="submit" name="Register" class="btn btn-block btn-success">Submit</button>
          </div>
          
 </form></div>
<?php
	include 'footer.php';
?>