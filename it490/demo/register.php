<?php
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
	session_start();
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$request = array();
	$request['type'] = "register";
	$request['username'] = $_POST["username"];
	$request['password'] = $_POST["password"];
	$request['email'] = $_POST["email"];
	$request['firstName'] = $_POST["firstName"];
	$request['lastName'] = $_POST["lastName"];
	$request['Address'] = $_POST["address"];
	$request['SATScore'] = $_POST["SATScore"];
	$request['major'] = $_POST["major"];
	$response = $client->send_request($request);
	$username = $request['username'];
?>

<html>
	<head>
		<title>Colleges.com: Register Failed</title>
		<link rel="stylesheet" type="text/css" href="style.css"
	</head>

	<body>
		<ul>
			<li style="color:green; border-right: 1px solid #bbb"><a href="index.html"><b>Colleges.com</b></a></li>
			<li><a href="register.html">Register</a></li>
			<li><a href="collegeList.php">College List</a></li>
			<li><a href="MajorList.php">Major List</a></li>
			<li style="float:right" class="dropdown" >
			    <a href="#" class="dropbtn">Logged in as: <?php if (isset($username)) {echo "<b>$username<b>";} else {echo "<b>Anonymous<b>";}?></a>
			    <div class="dropdown-content">
			      <a href="login.html">Login</a>
			    </div>
			  </li>
		</ul>

		<br><br>
		
		<div>
	
			<h1>Register</h1>

			<?php
				if ($response == "0")
				{
					session_start();
					$_SESSION["username"] = $username;
					header("Location: profile.php");
				}
				if ($response == "1")
				{
					echo "<center><b><font color='red'>Account could not be created. That email address is already in use.</center></b><br><br>";
					echo "<center><a href=register.html>Go Back</center></a>";
				}
				if ($response == "2")
				{
					echo "<center><b><font color='red'>Account could not be created. That username is already in use.</center></b><br><br>";
					echo "<center><a href=register.html> Go Back</a></center>";
				}
			?>
