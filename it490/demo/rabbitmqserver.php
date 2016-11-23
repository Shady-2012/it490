#!/usr/bin/php
<?php
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
		function requestProcessor($request)
		{
			echo "received request".PHP_EOL;
  			var_dump($request);
  			if(!isset($request['type']))
  			{
    			  return "ERROR: unsupported message type";
  			}
  			switch ($request['type'])
  			{
    				case "NJIT":
      				  return NJIT();
    				case "Rutgers":
      				  return Rutgers();
    				case "Colleges":
      				  return Colleges();
  			}
  			return array("returnCode" => '0', 'message'=>"Server received request and processed");
		}
		function NJIT() {
			 $con=mysqli_connect ("localhost", "Matt","ms629","it490");
			$sql="select * from NJIT";
        		$result=mysqli_query($con,$sql);
			$count=mysqli_num_rows($result);
			echo "$count\n";
			var_dump($result);
			
			$response=array();
			for ($i = 0; $i < $count;$i++)
			{
				$row = $result->fetch_array();
				echo "row data:";
				print_r($row);
				echo "\n";
				array_push($response,$row);
			}
			
			return $response;
			
 		      }
 		
		function Rutgers(){
        		 $con=mysqli_connect ("localhost", "Matt","ms629","it490");
			$sql="select * from RutgersNewark";
        		$result=mysqli_query($con,$sql);
			$count=mysqli_num_rows($result);
			echo "$count\n";
			var_dump($result);
			//if($count>0){
			//$sql="select * from CollegeList";
			//$result=mysqli_query($con,$sql);
			//var_dump($result);
			$response=array();
			for ($i = 0; $i < $count;$i++)
			{
				$row = $result->fetch_array();
				echo "row data:";
				print_r($row);
				echo "\n";
				array_push($response,$row);
//				echo $row;
			}
//			var_dump($response);
			//echo is_string($response);
			return $response;
			//return $row;	
 		      }
 		
		function Colleges(){
			
		        $con=mysqli_connect ("localhost", "root","shady","pass");
			$sql="select * from CollegeList";
        		$result=mysqli_query($con,$sql);
			$count=mysqli_num_rows($result);
			echo "$count\n";

			
			$response=array();
			for ($i = 0; $i < $count;$i++)
			{
				$row = $result->fetch_array();
				echo "row data:";
				print_r($row);
						
				echo "\n";
				array_push($response,$row);

			}

			return $response;
			
 		      }
		
	$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
	$server->process_requests('requestProcessor');
	exit();
?>

