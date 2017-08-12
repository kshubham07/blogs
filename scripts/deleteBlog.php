<?php
	if(!isset($_POST['id'])) return 'Invalid Command';
	require '../utils/models.php';
	require '../utils/getUser.php';
	$id=$_POST['id'];
	if($user->delete_blog($id)==0)
		echo 'Deleted successfully';
	else echo 'Could not delete';
?>