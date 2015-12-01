$(document).ready(function(){

	function search(){
		var query = $('#query').val();
		$.post('action.php', {query: query}, function(data){
			$('#search-container').html(data);
		});
	}

	$(document).on('click', '#submit', function() {
		search();
	});
	
	$(document).on('keyup', '#query', function(e) {
		if(e.keyCode == 13){
			search();
		}
	});
	
	$('#home').click(function(){
		$.post('search.php', {}, function(data){
			$('#myContent').html(data);
		});
	});
	
	$('#about').click(function(){
		$.post('about.php', {}, function(data){
			$('#myContent').html(data);
		});
	});

});