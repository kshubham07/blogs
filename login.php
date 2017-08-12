<?php
	if(isset($_COOKIE['myuser']))
	{
		header('Location:index.php');
	}
	if(isset($_POST['username']))
	{
		if(!empty($_POST['username']) && !empty($_POST['password']))
		{
			require 'utils/connect.php';
			$username = mysqli_real_escape_string($conn,$_POST['username']);
			$password = mysqli_real_escape_string($conn,$_POST['password']);
			$result = mysqli_query($conn,"select * from `user` where `username` = '".$username."' and `password` = '".$password."';");
			if(mysqli_num_rows($result)>0)
			{
				$time = time();
				$session_id = md5($username.$time);
				$exptime = $time+3*60*60;
				setcookie('myuser',$session_id,$exptime);
				mysqli_query($conn, "insert into `sessions` values ('".$session_id."','".$username."','".$exptime."');");
				header("Location:index.php");
			}
			else
				echo 'Invalid Credentials';
		}
	}
?>

<html>
	<head>
		<title>Login</title>
	</head>
	<body>
		<a href="register.php">Register</a>
		<a href="index.php">Blogs</a>
		<form action = "login.php" method="POST">
			Username : <input type="text" name="username"><br>
			Password : <input type="password" name="password"><br>
			<input type="submit">
		</form>
	</body>
</html>