
<?php
$con = mysqli_connect("localhost","root","shady","pass")  or die ("cannot connect");
$myusername=$_POST ['user'];
$mypassword=$_POST ['password'];
$myemail =$_POST['email'];
$sql="select * from login where email='$myemail'";
$result=mysqli_query($con,$sql);
$count=mysqli_num_rows($result);
if ($count >= 1){
echo "email already registered";}
else
{
$sql="INSERT INTO login (name,passwd,email) VALUES('$myusername',sha1('$mypassword'),'$myemail')";
if (mysqli_query ($con,$sql))
{echo"records added successfully";
?> <br>
<br>
<br>
<br>

<br>
<br>

<br>
<a href="profile.html"> click here to create your profile </a>

<body background="14.jpg">


<?php
}
else{
echo"error with entering data";
}
}
?>
