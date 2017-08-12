$(document).ready(function(){
	$("body").on("click","#saveBlogButton",function(){
		var title = $("#blog_title").val();
		var text = $("#blog_text").val();
		text = text.replace(/(?:\r\n|\r|\n)/g, '<br />');
		var audience = $("input[name='audience']:checked").val();
		if(title=='' || text=='' || audience=='')
		{
			alert("Title, text and audience are mandatory");
		}
		else
		{
			var tags = $("#blog_tag").val();
			var data = {blog_title : title, blog_text : text, blog_audience : audience, blog_tags : tags};
			$.post("scripts/saveBlog.php", data)
			.done(function(ret_data){
				alert(ret_data);
				if(ret_data=="Successfully Added")
				{
					location.reload();
				}
			});
		}
	});

	$('.edit').click(function(){
	});

	$('.delete').click(function(){
		var cnf = confirm("Are you sure you want to delete this?");
		if(cnf)
		{
			var id = this.id.substr(1,this.id.length);
			data = {id: id};
			$.post('scripts/deleteBlog.php',data)
			.done(function(ret_data){
				alert(ret_data);
				if(ret_data=="Deleted successfully")
				{
					location.reload();
				}
			});
		}
	});

	$('#myModal').modal({
    	backdrop: 'static',
    	keyboard: false
	});

});