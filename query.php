<?php
$db="sample_db"; //DB
		$host = "localhost";
		$username = "root";
		$password = "";
		$db = "sample_db";
		$db_table = "sample"; //DB table
		$conn=mysqli_connect($host,$username, $password, $db);
		if (!$conn) {
			die('Could not connect: ' . mysql_error());
		}
		else{
			echo "Connection Successful";
		}
		$col = 'Customer ID';
		$parameter = 'ZipcarS1';
		//$paramater = mysqli_real_escape_string($parameter);
		$query = "SELECT * FROM $db.$db_table WHERE `$col` = '$parameter'";
		//$query = "SELECT * FROM $db.$db_table";
		$result=mysqli_query($conn, $query) or trigger_error(mysqli_error()." ".$query);
		if($result){
			echo '<br/>';
			while ($row = mysqli_fetch_assoc($result)) {
				//print_r($row);
				$output = join(',', $row);
				echo($output);
				echo '<br/>';
			}
		}
		else{
			echo "Query failed";
		}
		mysqli_close($conn);
?>