<?php 

function sendsms($to,$msg)
{
    $array_data = array();
	$array_data["number"] = $to;
	$array_data["msg"] = $msg;
	
	//print_r($array_data);
	
    $session = curl_init('http://chauffeurlk.com/sms/sms.php');
    curl_setopt($session, CURLOPT_POST, true);
    curl_setopt($session, CURLOPT_POSTFIELDS, $array_data);
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_ENCODING, 'UTF-8');
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
	
    echo $response = curl_exec($session);
    curl_close($session);
    $results = json_decode($response, true);
    return $results;
}
?>
