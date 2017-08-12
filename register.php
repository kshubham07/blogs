<?php
	if(isset($_COOKIE['myuser']))
	{
		header('Location:index.php');
	}
	if(isset($_POST['username']))
	{
		if(!empty($_POST['username']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['password']) && !empty($_POST['password2']))
		{
			require 'utils/connect.php';
			$username = mysqli_real_escape_string($conn,$_POST['username']);
			$first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
			$last_name = mysqli_real_escape_string($conn,$_POST['last_name']);
			$password = mysqli_real_escape_string($conn,$_POST['password']);
			$password2 = mysqli_real_escape_string($conn,$_POST['password2']);
			if($password!=$password2)
			{
				echo 'Passwords do not match';
			}
			else
			{
				if(mysqli_query($conn, "insert into `user` values('".$username."','".$password."','".$first_name."','".$last_name."');"))
				{
					echo 'Registration Successful!';
				}
				else echo 'Could not register, sorry for inconvenience';
			}
		}
		else echo 'Fill in all fields';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>
	<a href="login.php">Login</a>
	<a href="index.php">Blogs</a>
	<form action="register.php" method="POST">
		Username : <input type="text" name="username"><br>
		First Name : <input type="text" name="first_name"><br>
		Last Name : <input type="text" name="last_name"><br>
		Password : <input type="password" name="password"><br>
		Retype Password : <input type="password" name="password2"><br>
		<input type="submit">
	</form>
</body>
</html>