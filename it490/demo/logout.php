<?php
	session_start();
	session_unset();
	session_destroy();
?>

<DOCTYPE html>
<html>
	<head>
		<title>Colleges.com</title>
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
			<p><center>You have successfully logged out</center></p>
		</div>
	</body>
</html>
