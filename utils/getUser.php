<?php
	/*
		models.php must be included BEFORE including this
	*/

	require 'connect.php';
	$now = time();
	mysqli_query($conn, "delete from `sessions` where `expiry`<".$now.";");
	if(!isset($_COOKIE['myuser']))
	{
		$user = new User("anonymous","ano","nymous",0);
	}
	else
	{
		$session_id = $_COOKIE['myuser'];
		$query_result = mysqli_query($conn,"select `sessions`.`username`,`user`.`first_name`,`user`.`last_name` from `sessions`,`user` where `sessions`.`session_id`='".$session_id."' AND `sessions`.`username` = `user`.`username`;");
		$query_handle = mysqli_fetch_assoc($query_result);
		$username = $query_handle["username"];
		$first_name = $query_handle["first_name"];
		$last_name = $query_handle["last_name"];
		$user = new User($username,$first_name,$last_name);
	}
?>