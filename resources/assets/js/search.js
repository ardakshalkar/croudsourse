var timer;
function up{
	timer = setTimeout(function(){
		var keywords = $('#search-input').val();

		if(keywords.length > 0){
			$.post('http://127.0.0.1:8000/posts/create', {keywords: keywords}, function(markup)
			{
				$('search-results').html(markup);
			});
		}
	}, 500);
}
function down(){
	
}