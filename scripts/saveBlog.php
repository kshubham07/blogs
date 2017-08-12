<?php
	if(isset($_COOKIE['myuser']))
	{
		require '../utils/connect.php';
		require '../utils/models.php';
		require '../utils/getUser.php';
		if($user->getAccess() == 1)
		{
			$blog_title = mysqli_real_escape_string($conn,$_POST["blog_title"]);
			$blog_text = mysqli_real_escape_string($conn,$_POST["blog_text"]);
			$blog_audience = mysqli_real_escape_string($conn,$_POST["blog_audience"]);
			$blog_tags = mysqli_real_escape_string($conn,$_POST["blog_tags"]);
			$blog = new Blog(-1,$blog_title, 0, $blog_text, $blog_tags, $blog_audience,0,0);
			$blog_id = $user->add_blog($blog);
			if($blog_id == -1)
				echo 'Error creating blog, sorry for inconvenience';
			else
			{
				$blog->setId($blog_id);
				echo 'Successfully Added';
			}
		}
		else
			echo 'You do not have permissions to post a blog';
	}
	else
		echo 'You are not logged in';
?>