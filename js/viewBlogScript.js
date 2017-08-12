$(document).ready(function(){
	$('#newCommentSubmitButton').click(function(){
		var comment = $('.newCommentBox').val();
		var blog = $('.newCommentBox').attr('id');
		if(comment=='' || comment==null)
			return false;
		comment = comment.replace(/(?:\r\n|\r|\n)/g, '<br />');
		data = {text: comment, blog: blog};
		$.post('scripts/addComment.php',data)
		.done(function(ret_data){
			if(ret_data=="ok")
			{
				location.reload();
			}
			else
			{
				alert(ret_data);
				return false;
			}
		});
	});
});