<?php
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
	session_start();
	$username = $_SESSION["username"];
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$request = array();
	$request['type'] = "profile";
	$request['username'] = $username;
	$response = $client->send_request($request);
	$length = count($response);
?>

<html>
	<head>
		<title>Colleges.com: Profile</title>
		<link rel="stylesheet" type="text/css" href="style.css">
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
			      <a href="logout.php">Logout</a>
			    </div>
			  </li>
		</ul>

		<br><br>

		<div>
			<h1>Profile</h1>
			<?php
				echo "<h2><center>Welcome $username!</center></h2><br><br>";
				for($i = 0; $i < $length; $i++)
				{
	    				echo $response[$i];
	    				echo "<br>";
				}
			?>
			<br><br>			
		</div>
	</body>
</html>
