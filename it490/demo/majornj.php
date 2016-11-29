<?php
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
	$client = new rabbitMQClient("testRabbitMQ.ini","DMZServer");
	
	
	$request['type'] = 'NJIT';
	$response = $client->send_request($request);
		$length = count($response);

             foreach ( $response as $k){
		
		echo "$k[0] <br>    ".PHP_EOL;
}
	
	echo "<a href=majoru.php> Rutgers Major</a><br>";
?>


