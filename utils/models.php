<?php
	class User{
		private $username;
		private $first_name;
		private $last_name;
		private $access = 0;

		/*
			============ACCESS VALUES================
			0 = none, only read permissions
			1 = self, read, CRUD blog, CRUD comment permissions
			2 = others, read, CRUD comment permissions
		*/

		public function User($username, $first_name, $last_name, $access=2)
		{
			$this->username = $username;
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->access = $access;
			if($username === "kshubham07")
				$this->access = 1;
		}


		public function register($password)
		{
			require 'connect.php';
			if(mysqli_query('insert into `user` values("'.$this->username.'","'.$password.'","'.$this->first_name.'","'.$this->last_name.'");'))
				return 0;
			defaults();
			return 1;
		}

		public function defaults()
		{
			$this->username = 'anonymous';
			$this->first_name = 'ano';
			$this->last_name = 'nymous';
			$this->access = 0;
		}

		public function add_blog($blog)
		{
			if($this->access == 1)
				return $blog->save();
		}

		public function search_by_tag($tag)
		{
			require 'connect.php';
			$query = "select * from `blog`,`audience` where `blog`.`blog_id` not in (select `blog_id` from `blog_deleted`) AND `blog_tag` like '%".$tag."%' AND `audience_private` = 0 AND `blog`.`blog_audience` = `audience`.`audience_id` order by `blog_date` desc";
			if($this->access == 1)
				$query = "select * from `blog` where `blog`.`blog_id` not in (select `blog_id` from `blog_deleted`) AND `blog_tag` like '%".$tag."%' order by `blog_date` desc;";
			$result = mysqli_query($conn,$query);
			$return = [];
			$i=0;
			while($handle = mysqli_fetch_assoc($result))
			{
				$blog = new Blog($handle["blog_id"], $handle["blog_title"], $handle["blog_date"], $handle["blog_text"], $handle["blog_tag"], $handle["blog_audience"], $handle['blog_likes'], $handle['blog_dislikes']);
				$return[$i++] = $blog;
			}
			return $return;
		}

		public function view_blogs()
		{
			$return = $this->search_by_tag('');
			return $return;
		}

		public function delete_blog($blog_id)
		{
			if($this->access == 1)
			{
				$blog = new Blog($blog_id,null,null,null,null,null,null,null);
				return $blog->delete();
			}
		}
	
		public function add_comment($blog_id,$comment)
		{
			if($this->access!=0)
			{
				if(($comm_id=$comment->save())!=-1)
					return $comm_id;
				else
					return -1;
			}
		}

		public function delete_comment($comment_id)
		{
			if($this->access!=0)
			{	
				$comment = new Comment($comment_id);
				$comment->delete($this->username);
			}
		}

		public function getAccess()
		{
			return $this->access;
		}

		public function getUsername()
		{
			return $this->username;
		}
	}

	class Blog{
		private $blog_id;
		private $blog_title;
		private $blog_date;
		private $blog_tag;
		private $blog_text;
		private $blog_audience;
		private $blog_likes;
		private $blog_dislikes;

		public function Blog($blog_id, $blog_title, $blog_date, $blog_text, $blog_tag, $blog_audience,$blog_likes, $blog_dislikes)
		{
			$this->blog_id = $blog_id;
			$this->blog_title = $blog_title;
			$this->blog_date = $blog_date;
			$this->blog_text = $blog_text;
			$this->blog_tag = $blog_tag;
			$this->blog_audience = $blog_audience;
			$this->blog_likes = $blog_likes;
			$this->blog_dislikes = $blog_dislikes;
		}

		public function save($time=0)
		{
			require 'connect.php';
			if($time == 0) $time = time();
			$this->blog_date = $time;
			if(!mysqli_query($conn, "insert into `blog` values (null,'".$this->blog_title."','".$this->blog_date."','".$this->blog_text."','".$this->blog_tag."','".$this->blog_audience."',0,0);"))
				return -1;
			return mysqli_insert_id($conn);
		}

		public function delete()
		{
			require 'connect.php';
			if(!mysqli_query($conn,"insert into `blog_deleted` values('".$this->blog_id."');"))
				return -1;
			else return 0;
		}

		public function getTitle()
		{
			return $this->blog_title;
		}

		public function getText()
		{
			return $this->blog_text;
		}

		public function getTag()
		{
			return $this->blog_tag;
		}

		public function getDate()
		{
			return $this->blog_date;
		}

		public function getSummary()
		{
			$summary = substr($this->blog_text, 0, 100);
			$summary = $summary."...<a href='viewBlog.php?id=".$this->blog_id."'>Read more</a>";
			return $summary;
		}

		public function getDateOfCreation()
		{
			return 'On '.date("d-m-Y", $this->blog_date);
		}

		public function getTimeOfCreation()
		{
			return ' at '.date("H:i", $this->blog_date);
		}

		public function getId()
		{
			return $this->blog_id;
		}

		public function setId($id)
		{
			$this->blog_id = $id;
		}

		public function getComments()
		{
			require 'connect.php';
			$comments = [];
			$i=0;
			$selectCommentQuery = 'select * from `comment` where `comment_blog`="'.$this->blog_id.'" order by `comment_time` desc;';
			$selectCommentResult = mysqli_query($conn,$selectCommentQuery);
			while($selectCommentHandle = mysqli_fetch_assoc($selectCommentResult))
			{
				$comment_id = $selectCommentHandle['comment_id'];
				$comment_text = $selectCommentHandle['comment_text'];
				$comment_user = $selectCommentHandle['comment_user'];
				$comment_time = $selectCommentHandle['comment_time'];
				$newComment = new Comment($comment_id,$comment_text,$this->blog_id,$comment_time,$comment_user);
				$comments[$i++]=$newComment;
			}
			return $comments;
		}
	}

	class Comment{
		private $comment_id;
		private $comment_text;
		private $comment_time;
		private $comment_user;
		private $comment_blog;

		public function Comment($comment_id, $comment_text="Text", $comment_blog=1, $comment_time, $comment_user="kshubham07")
		{
			$this->comment_id = $comment_id;
			$this->comment_text = $comment_text;
			$this->comment_blog = $comment_blog;
			$this->comment_user = $comment_user;
			$this->comment_time = $comment_time;
		}

		public function save($time=0)
		{
			require 'connect.php';
			if($time == 0) $time = time();
			$this->comment_time = $time;
			if(!mysqli_query($conn, "insert into `comment` values (null,'".$this->comment_text."','".$this->comment_user."','".$this->comment_blog."','".$this->comment_time."');"))
				return -1;
			return mysqli_insert_id($conn);
		}

		public function delete()
		{
			require 'connect.php';
			if(!mysqli_query($conn,"delete from `blog` where `blog_id` = ".$this->blog_id.";"))
				return -1;
			else return 0;
		}

		public function getUser(){
			return $this->comment_user;
		}

		public function getText(){
			return $this->comment_text;
		}

		public function getTime(){
			return date("d-m-Y @ H:i",$this->comment_time);
		}

	}

?>