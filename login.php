<?php
	include 'header.php';
?>

<div class="container">
	<h1>
		Login to the System
	</h1>
	<br>
	<form>
		<input type="text" class="form-control"	name="username" placeholder="enter a username"> <br>
		<input type="password" class="form-control"	name="password" placeholder="enter a password"> <br> 
		<input type="submit" id="login_button" class="btn btn-primary btn-block" value="Login">
		<br><div id="login_status"></div>
	</form>
	
<br>
<b>use the username "test" and password "test"" for the first login</b>
</div>

<script type="text/javascript">
j(document).ready(function () {
    j('#login_button').click(function (event) {
	event.preventDefault();

	var username = j("input[name=username]").val();
	var password = j("input[name=password]").val();

	if (username == '') {
		j("#un_status").attr('class','form-group has-warning').find(".un_status_sign").attr('class','un_status_sign input-group-addon').html('<i class="glyphicon glyphicon-remove"></i>').fadeIn("slow");
        return false;
    } else {
		j("#un_status").attr('class','form-group has-success').find(".un_status_sign").attr('class','un_status_sign input-group-addon').html('<i class="glyphicon glyphicon-ok"></i>').fadeIn("slow");
    }
	if (password == '') {
		j("#pw_status").attr('class','form-group has-warning').find(".pw_status_sign").attr('class','pw_status_sign input-group-addon').html('<i class="glyphicon glyphicon-remove"></i>').fadeIn("slow");
        return false;
    } else {
		j("#pw_status").attr('class','form-group has-warning').find(".pw_status_sign").attr('class','pw_status_sign input-group-addon').html('<i class="glyphicon glyphicon-ok"></i>').fadeIn("slow");
    }

	j('input').attr('disabled', true);

	j.ajax({
	   type: "POST",
	   dataType: 'json',
	   url: "login_proccess.php",
	   data: 'username='+ username +'&password='+ password +'&json=true',
	   cache: false,
	   success: function(data){
				if(data.result=="error"){
					j("#login_status").html('<div class="alert alert-warning">'+ data.message +'</div>').fadeIn("slow");
					j('input').attr('disabled', false);
				}
				if(data.result=="success"){
					j("#login_status").html('<div class="alert alert-success">'+ data.message +'</div>').fadeIn("slow");
					window.location = ("/customer.php");
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