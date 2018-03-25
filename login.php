<?php
if($_POST){
	session_start();
	//user authentication
	$_SESSION['host']="localhost"; //DB host
	$_SESSION['user']="root";  //DB admin name
	$_SESSION['pass']="";  //DB admin password
	$db="auth"; //DB table
	$username=$_POST['username'];
	$password=$_POST['password'];
	$conn=mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pass'], $db);
	$query="SELECT * from users where username='$username' and password='$password'";
	$result=mysqli_query($conn, $query);
	if(mysqli_num_rows($result)==1){
		$_SESSION['auth'] ='true';
		header('location:upload.php');
	}
	else{
		echo 'wrong username or password';
	}
}
?>
<form action="login.php" method="POST">
	<input type="text" name="username" placeholder="User Name">
	<input type="password" name="password" placeholder="Password">
	<input type="submit" name="submit" value="Submit">
</form>