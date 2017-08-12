<?php
	include '../utils/connect.php';
	include '../utils/models.php';
	include '../utils/getUser.php';
	if($user->getAccess()!=0)
	{
		if(isset($_POST['text']) && !empty($_POST['text']))
		{
			$text = mysqli_real_escape_string($conn,$_POST['text']);
			$blog = mysqli_real_escape_string($conn,$_POST['blog']);
			$comment = new Comment(-1,$text,$blog,time(),$user->getUsername());
			if($user->add_comment($blog,$comment) !=0)
				echo 'ok';
			else
				echo 'Could not add comment.';
		}
	}
	else echo 'Login first';
?>