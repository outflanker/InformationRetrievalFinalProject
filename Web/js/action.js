$(document).ready(function(){	
	function search(id){		
		var query = $("#"+id).val();
		$("#querySmall").val(query);
		if(typeof query === 'undefined'){
			alert("Query is empty! Please enter again!");
			return;
		}
		query=encodeURIComponent(query);
		//query = "text_ru:("+query+")";
	
		var querytmp = "text_en:("+query+")" + "+OR+";	
		querytmp = querytmp + "text_de:("+query+")"+ "+OR+";	
		querytmp = querytmp + "text_ru:("+query+")"+ "+OR+";	
		querytmp = querytmp + "text_es:("+query+")"+ "+OR+";
		querytmp = querytmp + "text_fr:("+query+")"+ "+OR+";
		querytmp = querytmp + "text_ar:("+query+")";
		query="("+querytmp+")";
	
        document.cookie	= query;
		$("#search-col").hide();
		$("#search-col-small").show();		
		$.post('action.php', {query: query}, function(data){
			$('#search-container').html(data);
		});		
	}
	function searchtags(query,isHashTag){
		document.cookie= query;		
		if(isHashTag){
			query = "tweet_hashtags:"+query;
			document.cookie = query;
		}
		else{
			query=encodeURIComponent(query);
			query = "content_tags:"+query;
			document.cookie = query;
		}
		query="("+query+")";
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
		query = document.cookie + "+AND+(+" + facetHeader + ":" + facet+")";	
        document.cookie=query;
		$.post('action.php', {query: query}, function(data){
			$('#search-container').html(data);
		});		
	})
	
});
$body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
    ajaxStop: function() { $body.removeClass("loading"); }    
});
