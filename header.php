<?php if(empty($title)) $title = "Chauffeur";  
if(isset($_COOKIE["user"])) session_start();  ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title><?php if(isset($title)) echo $title; ?></title>
<link rel="shortcut icon" href="/images/icon.png">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script src="jquery-3.3.1.min.js"></script>
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
<link href="/bootstrap/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" href="/fontawesome/css/fontawesome-all.min.css">
<style>
.nav-navy_blue
{
	background-color:#001f3f !important;
}
</style>
</head>
<body>
<script type="text/javascript">var j = jQuery.noConflict();</script>
 <header>
	<nav class="navbar navbar-expand-lg navbar-dark nav-navy_blue"> 
	<a
		class="navbar-brand" href="#">
		<!--<img src="/images/icon.png" height="20px" />--> The Chauffeur</a>
		<ul class="navbar-nav mr-auto">
		<li class="nav-item"><a class="nav-link text-white" href="/index.php"><i class="fa fa-home"></i> Home</a>
		</li>
	</ul>
	<ul class="navbar-nav">

		<?php include_once 'functions.php';
		
		if(isset($_COOKIE["user"])) 
					echo '<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="" id="dropdown_user" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Hello '.$_SESSION["user"].'</a>
						
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown_user">
						  <a class="dropdown-item" href="/'.strtolower($_SESSION['group']).'.php">Dashboard</a>
						  <div class="dropdown-divider"></div>
						  <a class="dropdown-item" href="/logout.php">logout</a>
						</div>'; 
				else
					echo '<li class="nav-item"><a class="nav-link text-white" href="/login.php"><i class="fa fa-user"></i> Login</a>'; 
		?>
 		</li>
	</ul>
	</nav>
 </header>
 <main role="main" class="container">
 <?php
 if(!isset($notloggedin)){
	 	if(!isset($_COOKIE["user"]))
	{
		echo '<div class="container">
		<h2 class="alert alert-danger">You have to login to access this page</h2><br>
		</div>';
		include 'footer.php'; die;
	}
 }
 
 
 ?>
