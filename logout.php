<?php
	if(isset($_COOKIE['myuser']))
	{
		$session_id = $_COOKIE['myuser'];
		require 'utils/connect.php';
		mysqli_query($conn,"delete from `sessions` where `session_id` = '".$session_id."';");
		setcookie('myuser','none',time()-1000);
	}
	header("Location:index.php");
?>