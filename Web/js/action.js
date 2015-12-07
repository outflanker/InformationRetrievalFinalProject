$(document).ready(function(){

	function search(){
		var query = $('#query').val();
		var query="http://10.84.18.140:8983/solr/project/select?q.alt=text_en:"+query;
		$.post('action.php', {query: query}, function(data){
			$('#search-container').html(data);
		});
	}
	function searchtags(query){		
		var query="http://10.84.18.140:8983/solr/project/select?wt=json&indent=true&defType=dismax&q.alt=tweet_hashtags:"+query;
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
	
	$("#search-container").on("click",".tree-toggle",function(){
		$(this).parent().children('ul.tree').toggle(200);    
	})
	
	$("#search-container").on("click",".hashtag",function(e){
		e.preventDefault();
		searchtags($(this).text().slice(1));
	})
});
