<?php
	//assmes $blog_id and $user to be set
	$checkBlogRes = mysqli_query($conn,'select * from `blog_deleted` where `blog_id`="'.$blog_id.'";');
	$blogOkay=false;
	if(mysqli_num_rows($checkBlogRes)==0)
	{
		$checkBlogRes2 = mysqli_query($conn,'select * from `blog` where `blog_id`="'.$blog_id.'";');
		if(mysqli_num_rows($checkBlogRes2)==1)
		{
			$blogHandle = mysqli_fetch_assoc($checkBlogRes2);
			if($user->getAccess()==1)
			{
				$blogOkay = true;
			}
			else
			{
				$checkBlogAudi = $blogHandle['blog_audience'];
				if($checkBlogAudi==2)
				{
					$blogOkay = true;
				}
			}
		}
	}
?>