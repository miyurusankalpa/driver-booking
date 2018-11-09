<?php
	include 'header.php';
	
	if(isset($_GET['prev'])) $prev = "previous"; else $prev = "this";
	
	$month_fd  = date("Y-n-j", strtotime("first day of $prev month"));
	$month_ld  = date("Y-n-j", strtotime("last day of $prev month"));

	$month = date('F Y', strtotime("$prev month"));
	
	  include_once 'mysqli.php';
  if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);
  $_COOKIE["user"]=$_GET['id'];
 $query2 = "SELECT sum(amount) as rev, count(bill_id) as trips FROM `billing` bi, booking bo WHERE bi.`time` BETWEEN '".$month_fd."' AND '".$month_ld."' AND bo.driver_id= '".$_COOKIE['user']."' ";

$result = mysqli_query($mysqli, $query2);

if(!$result) die("Error");

$row = mysqli_fetch_assoc($result);

echo '<div class="container">
	<a href="/monthly_report_driver.php?prev" class="btn btn-info">Previous Month</a>
	<a href="/monthly_report_driver.php" class="btn btn-info">Current Month</a>
	
	<h1>
		Monthly Report '.$month.' for '.get_fullname($_COOKIE['user']).'
	</h1>
	<br>
	
<br>
<h2>Total trips '.$row['trips'].'</h2>
<h2>Monthly revenue '.$row['rev'].' LKR</h2>
<br>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">User</th>
	  <th scope="col">Amt</th>
	  <th scope="col"></th>
    </tr>
  </thead>
  <tbody>';
  
  $query = "SELECT * FROM `billing` bi, booking bo WHERE bi.`time` BETWEEN '".$month_fd."' AND '".$month_ld."' AND bo.driver_id= '".$_COOKIE['user']."' ";
				
	$result = mysqli_query($mysqli, $query);

	while($row=mysqli_fetch_assoc($result))
    {
		echo '<tr>
		  <th scope="row">'.$row['bill_id'].'</th>
		  <td>'.get_fullname($row['uid']).'</td>
		  <td>'.$row['amount'].' LKR</td>
		  <td>
			<div class="btn-group" role="group">
				<a href="bill.php?id='.$row['bill_id'].'" class="btn btn-secondary btn-info">Bill</a>
			</div>
			</td>
		</tr>';
	}

echo '</tbody>
</table>

</div>';

	include 'footer.php';
?>
