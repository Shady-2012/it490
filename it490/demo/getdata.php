<?php
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$request = array();
	$request['type'] = "data";
	$request['major'] = $_POST["major"];
	$response = $client->send_request($request);
	if ($response == "0")
	{

		header("Location:p2.php");
	}
	
		

	/*$length = count($response);
	for($i = 0; $i < $length; $i++)
	{
    		 $response[$i];
    		echo "<br>";
	}*/
?>
