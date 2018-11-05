<?php include_once 'mysqli.php';
function booking_status2text($status)
{
	switch($status)
	{
		case 0;
			$status_t = "New Booking";
			break;
		case 1;
			$status_t = "Driver Booked";
			break;
		case 2;
			$status_t = "Vehicle Booked";
			break;
		case 3;
			$status_t = "Driver Accepted";
			break;
		case 4;
			$status_t = "Driver On the Way";
			break;
		case 5;
			$status_t = "Trip Started";
			break;
		case 6;
			$status_t = "Trip Complete";
			break;
		case 7;
			$status_t = "Payment Pending";
			break;
		case 8;
			$status_t = "Payment Complete";
			break;
		case 9;
			$status_t = "Cancelled Booking";
			break;
	}
	
	return $status_t;
}
function get_fullname($uid)
{	
	if($uid==0) return "Not Assigned";
	
	global $server, $user, $pass, $db;
	if(!isset($mysqli)) $mysqli = new mysqli($server, $user, $pass, $db);
		
	$query = "SELECT firstname, lastname FROM `users` WHERE `user_id` = ".$uid;			
	$row = mysqli_fetch_assoc(mysqli_query($mysqli, $query));
	
	if(empty($row['firstname'])) $name = "N/A"; else $name = $row['firstname']." ".$row['lastname'];
	
	return $name;
}
function time_elapsed($time,$rt=false)
    {
        if(!is_numeric($time))
            $time = strtotime($time);

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "age");
        $lengths = array("60","60","24","7","4.35","12","100");

        $now = time();

        $difference = $now - $time;
		if($rt){
        if ($difference <= 1 && $difference >= 0)
            return $tense = 'just now';
        elseif($difference > 0)
            $tense = 'ago';
        elseif($difference < 0)
            $tense = 'from now';
		} else {
		if ($difference <= 10 && $difference >= 0)
            return $tense = 'just now';
        elseif($difference > 0)
            $tense = 'ago';
        elseif($difference < 0)
            $tense = 'from now';
		}

		if($difference < 0) $difference = -1*$difference;

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        $period =  $periods[$j] . ($difference >1 ? 's' :'');
        return "{$difference} {$period} {$tense}";
}
function secondsToTime($inputSeconds) {
    $secondsInAMinute = 60;
    $secondsInAnHour = 60 * $secondsInAMinute;
    $secondsInADay = 24 * $secondsInAnHour;

    // Extract days
    $days = floor($inputSeconds / $secondsInADay);

    // Extract hours
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // Extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // Extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);

    // Format and return
    $timeParts = [];
    $sections = [
        'day' => (int)$days,
        'hour' => (int)$hours,
        'minute' => (int)$minutes,
       // 'second' => (int)$seconds,
    ];

    foreach ($sections as $name => $value){
        if ($value > 0){
            $timeParts[] = $value. ' '.$name.($value == 1 ? '' : 's');
        }
    }

    return implode(', ', $timeParts);
}
function distance2readable($meters)
{
	if($meters<100)
		return $meters." m";
	else
		return ($meters/1000)." km";
}
?>