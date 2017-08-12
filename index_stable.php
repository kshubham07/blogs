<?php
	require 'utils/connect.php';
	require 'utils/models.php';
	require 'utils/getUser.php';
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
		        <div class="form-group">
		          <input type="text" class="form-control" placeholder="Search Blogs">
		        </div>
		        <button id = "searchBlogsButton" type="submit" class="btn btn-default">Submit</button>
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
				<div id="createBlogWrapper">
					<button id="createBlogExpandButton" class="btn btn-default">Create new blog</button>
					<div id="createBlogDiv">
					</div>
				</div>
			<?php } 
			
			for($i=0;$i<sizeof($blogs);$i++)
				echo '	<div class="col-md-3">
							<div class="panel panel-default">
							  	<div class="panel-heading">'.$blogs[$i]->getTitle().'
							  	</div>
							  	<div class="panel-body">
							  		<div class="blogTimeDisplay">'.$blogs[$i]->getDateOfCreation().'</div>
							    	<p>'.$blogs[$i]->getSummary().'</p>
							  	</div>
							</div>
						</div>';
			?>
		</div>
	</body>
</html>