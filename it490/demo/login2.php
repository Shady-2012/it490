
<?php
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$request = array();
	$request['type'] = "login";
	$request['username'] = $_POST["username"];
	$request['password'] = $_POST["password"];
	$response = $client->send_request($request);
	$username = $request['username'];
	if ($response == "0")
	{
		session_start();
		$_SESSION["username"] = $username;
		header("Location: profile.php");
	}
	if ($response == "1")
	{
		echo "You have entered the wrong password.<br><br>";
		echo "<a href=login.html> Login</a>";
	}
	if ($response == "2")
	{
		echo "Username does not exist.<br><br>";
		echo "<a href=login.html> Login</a>";	
	}
?>
