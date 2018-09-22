<?php
function booking_status2text($status)
{
	switch($status)
	{
		case 0;
			$status_t = "Booked";
			break;
		case 1;
			$status_t = "Booked2";
			break;
	}
	
	return $status_t;
}
?>