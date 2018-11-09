<?php  $notloggedin=true;
	include 'header.php';
?>

<div class="card card-body bg-light">
	<h2 class="text-center">Login</h2>
	<hr>
	<form>
	
		<div class="form-group row">
          	<label class="col-sm-2 col-form-label">Username</label>
		<div class="col-sm-10">
          	   <input type="text" class="form-control" name="username" required="">
         	</div>  
	   </div>
	   <div class="form-group row">
          	<label class="col-sm-2 col-form-label">Password</label>
		<div class="col-sm-10">
          	   <input type="password" class="form-control" name="password" required="">
         	</div>  
	   </div>
	   
		<input type="submit" id="login_button" class="btn btn-success btn-block" value="Login">
		<br><div id="login_status"></div>
	</form>
	
<br>
</div>

<script type="text/javascript">
j(document).ready(function () {
    j('#login_button').click(function (e) {

	e.preventDefault();

	if(!j(this).closest('form')[0].checkValidity()){
		return false;
	} 
	
	var username = j("input[name=username]").val();
	var password = j("input[name=password]").val();

	j('input').attr('disabled', true);

	j.ajax({
	   type: "POST",
	   dataType: 'json',
	   url: "login_process.php",
	   data: 'username='+ username +'&password='+ password +'&json=true',
	   cache: false,
	   success: function(data){
				if(data.result=="error"){
					j("#login_status").html('<div class="alert alert-warning">'+ data.message +'</div>').fadeIn("slow");
					j('input').attr('disabled', false);
				}
				if(data.result=="success"){
					j("#login_status").html('<div class="alert alert-success">'+ data.message +'</div>').fadeIn("slow");
					
					if(data.group=="Customer") window.location = ("/customer.php");
					if(data.group=="Driver") window.location = ("/driver.php");
					if(data.group=="Admin")	window.location = ("/admin.php");
				}
			},
		error: function(jqXHR,error, errorThrown){
			j("#login_status").html('<div class="alert alert-danger">OH! :O There was a unexpected error :(</div>').fadeIn("slow");
			j('input').attr('disabled', false);
		}
		});
	});
});
</script>

<?php
	include 'footer.php';
?>