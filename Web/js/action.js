$(document).ready(function(){	
	function search(id){		
		var query = $("#"+id).val();
		$("#querySmall").val(query);		
		document.cookie = "text_en:"+query;		
		var query="http://ufkk59b06f3a.farhahum.koding.io:8983/solr/project/select?q.alt=text_en:"+query;
		$("#search-col").hide();
		$("#search-col-small").show();		
		$.post('action.php', {query: query}, function(data){
			$('#search-container').html(data);
		});		
	}
	function searchtags(query,isHashTag){
		document.cookie= query;		
		if(isHashTag){
			document.cookie = "tweet_hashtags:"+query;
			var query="http://ufkk59b06f3a.farhahum.koding.io:8983/:8983/solr/project/select?wt=json&indent=true&defType=dismax&q.alt=tweet_hashtags:"+query;
		}
		else{
			document.cookie = "content_tags:"+query;
			var query="http://ufkk59b06f3a.farhahum.koding.io:8983/solr/project/select?wt=json&indent=true&defType=dismax&q.alt=content_tags:"+query;
		}
		alert(document.cookie);
		$.post('action.php', {query: query}, function(data){
			$('#search-container').html(data);
		});
	}

	$(document).on('click', '.submit', function() {
		search($(this).attr("id"));
	});
	
	$(document).on('keyup', '.query', function(e) {
		if(e.keyCode == 13){
			search($(this).attr("id"));
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
		searchtags($(this).text().slice(1),true);
	})
	
	$("#search-container").on("click",".tags",function(e){
		e.preventDefault();
		searchtags($(this).text(),false);
	})
	
	$("#search-container").on("click",".facet",function(e){
		var dict = {
		"Language" : "lang",
		"English" : "en",
		"German" : "de",
		"Russian" : "ru",
		"Spanish" : "es",
		"French" : "fr",
		"Arabic" : "ar",
		"Tweet Hashtags" :"tweet_hashtags",
		"Content Tags":"content_tags",
		"Location" : "location"
		};
		
		var facetName = $(this).text();
		var facet = facetName.substring(0, facetName.indexOf('('));
		var facetHeader = $(this).parent().parent().parent().children(":first").text();			
		
		if(typeof (dict[facet])!='undefined')
			facet = dict[facet];
		if(typeof (dict[facetHeader])!='undefined')
			facetHeader = dict[facetHeader];
		
		e.preventDefault();
		document.cookie = document.cookie +", "+ facetHeader + ":" + facet;		
		alert(document.cookie);
	})
	
});
$body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});
