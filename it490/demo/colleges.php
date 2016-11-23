<?php
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	
	
	$request['type'] = 'Colleges';
	$response = $client->send_request($request);
		$length = count($response);

             foreach ( $response as $k){
		
		echo "$k[0] <br>    ".PHP_EOL;
}/**
		foreach($i = 0; $i < $length; $i++)
		{
		print($response);
			echo "<br>";
		}
	*/
	
	echo "<a href=majorsList.html> List of Majors</a><br>";
?>


