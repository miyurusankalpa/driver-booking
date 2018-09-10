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
		<!--<img src="/images/icon.png" height="20px" />--> the chauffeur</a>
		<ul class="navbar-nav mr-auto">
		<li class="nav-item"><a class="nav-link text-white" href="/index.php"><i class="fa fa-home"></i> Home</a>
		</li>
	</ul>
	<ul class="navbar-nav">
		<?php if(isset($_COOKIE["user"])) 
					echo '<li class="nav-item dropdown" role="button" data-toggle="dropdown">
						<a class="nav-link text-white dropdown-toggle" href="#"><i class="fa fa-user"></i> Hello '.$_SESSION["user"].'</a>
						
						<div class="dropdown-menu dropdown-menu-right">
						  <a class="dropdown-item" href="123">Action</a>
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