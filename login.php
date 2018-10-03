<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);

session_start(); // Starting Session
$error=''; // Variable To Store Error Message
	if (isset($_POST['submit'])) {
		if (empty($_POST['username']) || empty($_POST['password'])) {
		$error = "Username or Password is invalid";
	}
	else
	{
		// Define $username and $password
		$username=$_POST['username'];
		$password=$_POST['password'];
		// Establishing Connection with Server by passing server_name, user_id and password as a parameter
		$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
		// To protect MySQL injection for Security purpose
		$username = stripslashes($username);
		$password = stripslashes($password);
		$username = mysqli_real_escape_string($con, $username);
		$password = mysqli_real_escape_string($con, $password);

		// SQL query to fetch information of registerd users and finds user match.
		$sql = "SELECT * FROM cswd_account_listing WHERE password='$password' AND username='$username'";
		$result = mysqli_query($con,$sql);

		$record = mysqli_fetch_array($result);

		$rows = mysqli_num_rows($result);
		$x =  $record['account_name'];

		if ($rows == 1) {
			$_SESSION['login_user']=$username;
			if($x == 'CSWD') { header("location: cswd-account-dashboard.php"); }
			else if($x == 'CSWD Driver') { header("location: cswd-driver-dashboard.php"); }
			else if($x == 'Barangay') { header("location: cswd-barangay-dashboard.php"); }
		} 
		else { header("location: index.php"); }
		mysqli_close($con); // Closing Connection
	}
}
?>