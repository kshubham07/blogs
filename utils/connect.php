<?php
	if($conn = mysqli_connect('localhost','root',''))
	{
		if(mysqli_select_db($conn,'blog'))
		{
		}
		else
			die('Can\'t select DB');
	}
	else die('Can\'t open database');
?>