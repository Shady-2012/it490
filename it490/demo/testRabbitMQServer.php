#!/usr/bin/php
<?php
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
	function doLogin($username,$password)
	{
		$con=mysqli_connect ("localhost","root","shady","pass");
		$login = fopen("login.txt", "a") ;
		$date = date("Y-m-d");
		$time = date("h:i:sa");
		$sql="select * from login where name = '$username'";
		$result=mysqli_query($con,$sql);
		$count=mysqli_num_rows($result);
		if ($count < 1)
		{
			//username does not exist
			$response = "2";
			$string = "$date $time Response Code 2: Username $username does not exist.\n";
			fwrite($login, $string);
			echo $response;
			return $response;
		}
		else
		{
			$sql="select * from login where name = '$username' AND passwd = sha1('$password')";
			$result=mysqli_query($con,$sql);
			$count=mysqli_num_rows($result);
			if ($count == 1)
			{
				//login successful
				$response = "0";
				$string = "$date $time Response Code 0: Login successful for username $username.\n";
				fwrite($login, $string);
				echo $response.PHP_EOL;
				return $response;
			}
			elseif ($count == 0)
			{
				//wrong password
				$response = "1";
				$string = "$date $time Response Code 1: Wrong password for username $username.\n";
				fwrite($login, $string);
				echo $response.PHP_EOL;
				return $response;
			}
		}
	}
	function doRegister($username, $password, $email, $firstname, $lastname, $address, $sat , $major)
	{
		$register = fopen("register.txt", "a") ;
		$date = date("Y-m-d");
		$time = date("h:i:sa");
		$con = mysqli_connect("localhost","root","shady","pass")  or die ("cannot connect");
		$sql="select * from login where email='$email'";
		$result=mysqli_query($con,$sql);
		$count=mysqli_num_rows($result);
		if ($count >= 1)
		{
			//echo "email already registered";
			$response = "1";
			$log = "$date $time Response Code 1: Email $email already registered.\n";
			fwrite($register, $log);
			echo $response;
			return $response;	
			
		}
		$sql="select * from login where name ='$username'";
		$result=mysqli_query($con,$sql);
		$count=mysqli_num_rows($result);
		if ($count >= 1)
		{
			//username already in use
			$response = "1";
			$log = "$date $time Response Code 2: Username $username already in use.\n";
			fwrite($register, $log);
			echo $response;
			return $response;	
		}



		else
		{
			$sql="INSERT INTO login (name, passwd, email, firstname, lastname, address, sat, major) VALUES('$username', sha1('$password'),'$email', '$firstname','$lastname','$address','$sat','$major')";
			if (mysqli_query ($con,$sql))
			{
				//inserted into database
				$response = "0";
				$log = "$date $time Response Code 0: Email $email successfully added to database.\n";
				fwrite($register, $log);
				echo $response;
				return $response;
			}
		}
	}

	function getProfile($username)
	{	
		$con=mysqli_connect ("localhost","root","shady","pass");
		$sql="select * from login where name = '$username'";
		$result=mysqli_query ($con,$sql);
		$count=mysqli_num_rows ($result);
		while ($row=mysqli_fetch_array($result))
		{
			$email = $row['email'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];		
			$address = $row['address'];
			$sat = $row['sat'];
			$major = $row['major'];
		}
		$response = array($email, $firstname, $lastname, $address, $sat, $major);
		return $response;
		
	}


	function requestProcessor($request)
	{
		global $response;
		echo "received request".PHP_EOL;
		var_dump($request);
		if(!isset($request['type'])){return "ERROR: unsupported message type";}
		switch ($request['type'])
		{
			case "login":
				return doLogin($request['username'],$request['password']);
			case "profile":
				return getProfile($request['username']);
			case "validate_session":
				return doValidate($request['sessionId']);
			//case "colleges":
			//	return doColleges($request['colleges']);
			case "register":
				return doRegister($request['username'],$request['password'],$request['email'], $request['firstname'],$request['lastname'],$request['address'],$request['sat'],$request['major']);

			case "logout":
				return doLogout($request['username'],$request['password'],$request['sessionId']);
		}
		return $response;
	}
	$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
	$server->process_requests('requestProcessor');
	exit();
?>
