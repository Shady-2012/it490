
<?php
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

	session_start();
	$username = $_SESSION["username"];

	$request = array();
	$request['type'] = "profile";
	$request['username'] = $username;
	$response = $client->send_request($request);

	$_SESSION = $response;
	echo "<p1> Welcome $username!</p1><br><br>";	
	$length = count($response);
	for($i = 0; $i < $length; $i++)
	{
    		echo $response[$i];
    		echo "<br>";
	}
	echo "<br><a href=collegeList.html> List of Colleges</a><br>";
	echo "<a href=majorsList.html> List of Majors</a><br>";
?>
