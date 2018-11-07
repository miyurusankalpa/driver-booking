<?php include_once 'mysqli.php';
function booking_status2text($status,$t=1)
{
	switch($status)
	{
		case 0;
			$status_t = "New Booking";
			$status_b = "light";
			break;
		case 1;
			$status_t = "Driver Booked";
			$status_b = "info";
			break;
		case 2;
			$status_t = "Vehicle Booked";
			$status_b = "info";
			break;
		case 3;
			$status_t = "Driver Accepted";
			$status_b = "primary";
			break;
		case 4;
			$status_t = "Driver On the Way";
			$status_b = "info";
			break;
		case 5;
			$status_t = "Trip Started";
			$status_b = "dark";
			break;
		case 6;
			$status_t = "Trip Complete";
			$status_b = "success";
			break;
		case 7;
			$status_t = "Payment Pending";
			$status_b = "warning";
			break;
		case 8;
			$status_t = "Payment Complete";
			$status_b = "success";
			break;
		case 9;
			$status_t = "Cancelled Booking";
			$status_b = "danger";
			break;
	}
	
	if($t==1) return $status_t; else return $status_b;
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
function booking_mail($name,$bid,$add){
	$html = '<tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                    <tr>
                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;text-align: center;">
					  <img src="https://chauffeurlk.com/images/logo.png" height="100px"><br><br>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Hello '.$name.'</p>
						<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><br>Trip ID : '.$bid.' <br>'.$add.'<br></p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Your booking status has been updated. To view the lastest status and more infomataion about the booking click the button below.</p>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                          <tbody>
                            <tr>
                              <td align="center" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                                  <tbody>
                                    <tr>
                                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;"> <a href="https://chauffeurlk.com/status_booking.php?id='.$bid.'" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Booking status</a> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Thanks for using chauffeurlk.</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>';
	return $html;
}
function billing_mail($name,$bid,$add){
	$html = '<tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                    <tr>
                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;text-align: center;">
					  <img src="https://chauffeurlk.com/images/logo.png" height="100px"><br><br>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Hello '.$name.'</p>
						<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><br>Bill ID : '.$bid.' <br>'.$add.'<br></p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Your bill status has been updated. To view the lastest status and more infomataion about the bill click the button below.</p>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                          <tbody>
                            <tr>
                              <td align="center" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                                  <tbody>
                                    <tr>
                                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;"> <a href="https://chauffeurlk.com/bill.php?id='.$bid.'" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Billing status</a> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Thanks for using chauffeurlk.</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>';
	return $html;
}
?>