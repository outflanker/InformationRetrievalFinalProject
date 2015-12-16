<?php
if(isset($_POST['query']) and !empty($_POST['query'])){
	$query = $_POST['query'];
	$facetNames = array(
		"lang"=>"Language",
		"en"=>"English",
		"de"=>"German",
		"ru"=>"Russian",
		"es"=>"Spanish",
		"fr"=>"French",
		"ar"=>"Arabic",
		"tweet_hashtags"=>"Tweet Hashtags",
		"content_tags"=>"Content Tags",
		"location"=>"Location"
	);
?>
	<div class="row">
		  <?php 
			echo $query;
			$url="http://52.35.194.159:8983/solr/project/select?wt=json&indent=true&defType=dismax&q.alt=";
			$query=urlencode($query);
			$query=$url.$query;
			echo $query;
			$ch=curl_init($query);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			curl_close($ch);	
			$returnjson=json_decode($result,true);
			$response=$returnjson['response'];
			$responseCount=$response['numFound'];	
			$tweets=$response['docs'];
			
			$facets=$returnjson['facet_counts'];
			?>		   
           <div class="col-lg-3">       
				<h4>Show results by:</h4>			
				<ul class="nav nav-list">
				<?php 
					foreach($facets['facet_fields'] as $facets=>$values){
						$facetHeader=$facets;
						if(array_key_exists($facetHeader,$facetNames)){
									$facetHeader=$facetNames[$facetHeader];
								}
				?>
					<li><label class="tree-toggle nav-header facetHeader"><?php echo $facetHeader;?></label>
						<ul class="nav nav-list tree">
						<?php
							for($j=0;$j<count($values);$j+=2){
								$facetName=$values[$j];
								if(array_key_exists($values[$j],$facetNames)){
									$facetName=$facetNames[$facetName];
								}															
						?>
							<li><a href="#" class="facet"><?php echo $facetName."(".$values[$j+1].")"; }?></a></li>
						</ul>
					</li>
				<?php
				}
				?>
				</ul>
           </div>
		   <div class="col-lg-8">		   
		   <?php
				for($i=0;$i<$responseCount;$i=$i+2)
				{
					$tweet1=$tweets[$i];
					$tweet2=$tweets[$i+1];
		   ?>		
			<div class="row">
			   <div class="col-lg-6">
				   <div class="panel panel-default">
					   <div class="panel-heading"><a href="https://twitter.com/statuses/<?php echo $tweet1['id'];?>"><?php echo $tweet1['user_screen_name']; ?></a></div>
					   <div class="panel-body">
						   <p>
								<?php 
								$tweettext= preg_replace('/https?:\/\/[\w\-\.!~#?&=+\*\'"(),\/]+/','<a href="$0">$0</a>',$tweet1['text_en']);
								$tweettext= preg_replace("/#([a-z_0-9]+)/i", "<a href=\"#\" class=\"hashtag\">$0</a>", $tweettext);
								echo preg_replace("/@(\w+)/i", "<a href=\"http://twitter.com/$1\">$0</a>", $tweettext);
								?> 
							</p>
						   	   <?php
							   if(isset($tweet1['content_tags'])){
							   ?>
							   <ul class="list-inline">
							   <?php
									foreach($tweet1['content_tags'] as $tag){
								?>
									<li><button class="btn btn-sm tags"><?php echo substr($tag,0,strpos($tag,",")); ?></button></li>
								<?php
								}
								}
							    ?>
						   </ul>
					   </div>
				   </div>
			   </div>
			   <div class="col-lg-6">
				   <div class="panel panel-default">
					   <div class="panel-heading"><a href="https://twitter.com/statuses/<?php echo $tweet2['id'];?>"><?php echo $tweet2['user_screen_name']; ?></a></div>
					   <div class="panel-body">
						   <p>
								<?php 
								$tweettext= preg_replace('/https?:\/\/[\w\-\.!~#?&=+\*\'"(),\/]+/','<a href="$0">$0</a>',$tweet2['text_en']);
								$tweettext= preg_replace("/#([a-z_0-9]+)/i", "<a href=\"#\" class=\"hashtag\">$0</a>", $tweettext);
								echo preg_replace("/@(\w+)/i", "<a href=\"http://twitter.com/$1\">$0</a>", $tweettext);
								?> 
							</p>
						   	   <?php
							   if(isset($tweet2['content_tags'])){
							   ?>
							   <ul class="list-inline">
							   <?php
									foreach($tweet2['content_tags'] as $tag){
								?>
									<li><button class="btn btn-sm tags"><?php echo substr($tag,0,strpos($tag,",")); ?></button></li>
								<?php
								}
								}
							    ?>
						   </ul>
					   </div>
				   </div>
			   </div>
		   	</div>
		   <?php
		   }
		   ?>
       </div>
	</div>	
<?php
}
?>
<div class="modal"></div>
