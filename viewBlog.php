<?php
	require 'utils/connect.php';
	require 'utils/models.php';
	require 'utils/getUser.php';
	if(isset($_GET['id']) && !empty($_GET['id']))
	{
		$blog_id=$_GET['id'];
		require 'utils/checkBlog.php';
		if($blogOkay)
		{
			$title = $blogHandle["blog_title"];
			$text = $blogHandle["blog_text"];
			$tags = $blogHandle["blog_tag"];
			$date = $blogHandle["blog_date"];
			$likes = $blogHandle["blog_likes"];
			$dislikes = $blogHandle["blog_dislikes"];
			$audi = $blogHandle["blog_audience"];
			$thisBlog = new Blog($blog_id, $title, $date, $text, $tags, $audi ,$likes, $dislikes);
			$comments = $thisBlog->getComments();
			?>
			<html>
				<head>
					<title><?php echo $thisBlog->getTitle();?></title>
					<script type="text/javascript" src="js/jquery.js"></script>
					<script type="text/javascript" src="js/viewBlogScript.js"></script>
				</head>
				<body>
					<h2><?php echo $thisBlog->getTitle();?></h2>
					<p><?php echo $thisBlog->getDateOfCreation().$thisBlog->getTimeOfCreation();?></p>
					<p><?php echo $thisBlog->getText();?></p>
					<p><?php echo $thisBlog->getTag();?></p>
					<br>
					<?php
						for($i=0;$i<sizeof($comments);$i++)
						{
							echo '<p>'.$comments[$i]->getUser().' says: '.$comments[$i]->getText().' at '.$comments[$i]->getTime().'</p>';
						}
					?>
						<textarea rows="2" class="newCommentBox" id=<?php echo $thisBlog->getId(); ?> required></textarea>
						<button id="newCommentSubmitButton">Add new Comment</button>
				</body>
			</html>

			<?php
		}
		else
		{
			echo 'Error 404 : Blog does not exist';
		}
	}
	else
		echo 'Error 404 : Blog does not exist';	
?>