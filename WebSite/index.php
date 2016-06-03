<?php
$nameDB ="***"; //Your database login
$user = "***";
$psw = "***";
$namedb = "***";
session_start();
$_SESSION['nameDB'] = $nameDB;
$_SESSION['user'] = $user;
$_SESSION['psw'] = $psw;
$_SESSION['namedb'] = $namedb;

if(isset($_POST['submit1']))
{
	$connection = mysqli_connect($nameDB,$user,$psw,$namedb);
	if(!$connection) echo('<script>alert("DB connection error");</script>');
	else
	{
		$username=$_POST['username'];
		$password=$_POST['password'];
		$query = mysqli_query($connection,"SELECT Name from users WHERE Password='".$password."' AND Username='".$username."';"); //Control query
		$rows = mysqli_num_rows($query);
		if ($rows == 1) 
		{
			$_SESSION['access'] = $username;
			header("location: pprinc.php");
		} 
		else 
		{
			echo '<script>alert("User already exist or wrong password");</script>';
		}
	}
	mysqli_close($connection);
}
?>
<html>
	<head>
		<title>BonsArduino</title>
		<script type="text/javascript">
			function check()
			{
				var username1 = document.getElementById("username").value;
				var password1 = document.getElementById("password").value;
				
				if (username1 === undefined || username1 == "" || password1 === undefined || password1 == "")
				{
					alert("Double check fields.");
				}
				else
				{
					document.getElementById("login").action="index.php";
					document.getElementById("login").method="POST";
					document.getElementById("login").submit();
				}
			}
		</script>
	</head>
	<body>	
		<h1>Login</h1>
		<form id="login">
			Username: <input type = "text" name = "username" placeholder = "Insert Username" id= "username1">
			<br><br>
			Password: <input type = "password" name = "password" placeholder = "Insert Password" id = "password1">
			<br><br>
			<button name="submit1" onClick="check();">Login</button>
		</form>
	</body>
</html>