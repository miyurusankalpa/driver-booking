<?php include_once 'mysqli.php';
function booking_status2text($status)
{
	switch($status)
	{
		case 0;
			$status_t = "New Booking";
			break;
		case 1;
			$status_t = "Booked2";
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
?>