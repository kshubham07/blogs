<?php
	require 'utils/connect.php';
	require 'utils/models.php';
	require 'utils/getUser.php';
	if(isset($_POST['searchByTags']))
	{
		$searchByTags = mysqli_real_escape_string($conn,$_POST['searchByTags']);
		$blogs = $user->search_by_tag($searchByTags);
	}
	else
		$blogs = $user->view_blogs();
?>

<html>
	<head>
		<title>Blogs</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
	</head>
	<body>

		<nav class="navbar navbar-default mynavbar">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <?php
				echo '<div class="navbar-brand">Welcome, '.$user->getUsername().'</div>';
				?>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      
		      <div class="navbar-form navbar-left">
		        <form action="index.php" method="POST">
		        <div class="form-group">
		          <input type="text" name="searchByTags" class="form-control" placeholder="Search Blogs">
		        </div>
		        <button id = "searchBlogsButton" type="submit" class="btn btn-default">Submit</button>
		      	</form>
		      </div>
		      <ul class="nav navbar-nav navbar-right">
        		<?php 
				if($user->getAccess()==0)
				{?>
					<li><a href="login.php">Login</a></li>
					<li><a href="register.php">Register</a></li>
					<?php }
					else{
						echo '<li><a href="logout.php">Logout</a></li>';
					}
				?>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

		<div id="myCarousel" class="carousel slide mycarousel" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		    <li data-target="#myCarousel" data-slide-to="1"></li>
		    <li data-target="#myCarousel" data-slide-to="2"></li>
		    <li data-target="#myCarousel" data-slide-to="3"></li>
		    <li data-target="#myCarousel" data-slide-to="4"></li>
		    <li data-target="#myCarousel" data-slide-to="5"></li>
		   </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner">
		    <div class="item active">
		      <img src="images/0.png" width="100%" height="350px" alt="Algorithms">
		    </div>

		    <div class="item">
		      <img src="images/1.png" alt="Computer Science">
		    </div>

		    <div class="item">
		      <img src="images/2.jpg" alt="Sports">
		    </div>

		    <div class="item">
		      <img src="images/3.png" alt="Technology">
		    </div>

		    <div class="item">
		      <img src="images/4.png" alt="Emotional Health">
		    </div>

		    <div class="item">
		      <img src="images/5.jpg" alt="News">
		    </div>
		  </div>

		  <!-- Left and right controls -->
		  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#myCarousel" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
		<div class="col-md-12" id="blogs_description">
		<?php
			if($user->getAccess()==1){
				?>
				<!-- Button trigger modal -->
			<div class="col-md-12 style='padding: 10px; margin: 10px;'">
			<button type="button" class="btn btn-primary btn-lg spaceBottom" data-toggle="modal" data-target="#myModal">
			  Create new Blog
			</button>
			</div>
			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">What's on your mind...</h4>
			      </div>
			      <div class="modal-body">
        			<div class="form-control" id="blog_audience">
						Type of Blog : <input type="radio" name="audience" value="1">Private</input>
						<input type="radio" name="audience" value="2">Public</input>
					</div><br/>
					<input type="text" placeholder="Title" maxlength="70" class="form-control" id="blog_title"><br/>
					<textarea placeholder="Text" class="form-control" id="blog_text" rows="10"></textarea><br/>
					<input placeholder="Tags" maxlength="50" class="form-control" type="text" id="blog_tag"><br/>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button class="btn btn-primary" id="saveBlogButton">Save Blog</button>
			      </div>
			    </div>
			  </div>
			</div>
			<?php } 
			for($i=0;$i<sizeof($blogs);$i++)
				{
					echo '	<div class="col-md-3" id="blog'.$blogs[$i]->getId().'">
							<div class="panel panel-default">
							  	<div class="panel-heading">'.$blogs[$i]->getTitle().'
							  	</div>
							  	<div class="panel-body">
							  		<div style="min-height:20px;">
							  			<div class="blogTimeDisplay pull-left">'.$blogs[$i]->getDateOfCreation().'</div>
							  			<div class="blogTagDisplay pull-right">'.$blogs[$i]->getTag().'</div>
							    	</div>
							    	<br>
							    	<p>'.$blogs[$i]->getSummary().'</p>
							  	</div>
							  	';
							  	if($user->getAccess()==1)
							  	{
							  		echo '<div class="panel-footer">
							  		<button class="btn-hide edit" id="e'.$blogs[$i]->getId().'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
							  		<button class="btn-hide delete pull-right" id="d'.$blogs[$i]->getId().'"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
							  		</div>';
							  	}
						echo '</div>
						</div>';
					}
			?>
		</div>
	</body>
</html>