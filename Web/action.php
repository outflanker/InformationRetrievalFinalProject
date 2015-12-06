<?php

if(isset($_POST['query']) and !empty($_POST['query'])){
	$query = $_POST['query'];
?>
	<div class="row">
		  <?php 
			//$ch=curl_init('http://outflanker.koding.io:8983/solr/project2/select?q=text_en:'.$query.'&wt=json&rows=1000');
			$ch=curl_init('http://10.84.16.204:8983/solr/project/select?q=text_en:'.$query.'&wt=json&rows=1000');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			curl_close($ch);	
			$returnjson=json_decode($result,true);
			$response=$returnjson['response'];
			$responseCount=$response['numFound'];	
			$tweets=$response['docs'];
			?>

           <div class="col-lg-2">
               <h3>Show Results by</h3>
               <ul class="list-group">
                   <li class="list-group-item"><span class="badge">14</span><button class="btn">Russia</button></li>
                   <li class="list-group-item"><span class="badge">12</span><button class="btn">ISIS</button></li>
                   <li class="list-group-item"><span class="badge">2</span><button class="btn">Putin</button></li>
                   <li class="list-group-item"><span class="badge">50</span><button class="btn">Refugee Crisis</button></li>
               </ul>
           </div>
		   <?php
				for($i=0;$i<$responseCount;$i=$i+2)
				{
					$tweet1=$tweets[$i];
					$tweet2=$tweets[$i+1];
		   ?>
		   <div class="col-lg-8">
			   <div class="col-lg-6">
				   <div class="panel panel-default">
					   <div class="panel-heading"><a href="https://twitter.com/statuses/<?php echo $tweet1['id'];?>"><?php echo $tweet1['user_screen_name']; ?></a></div>
					   <div class="panel-body">
						   <p>
								<?php 
								$tweettext= preg_replace('/https?:\/\/[\w\-\.!~#?&=+\*\'"(),\/]+/','<a href="$0">$0</a>',$tweet1['text_en']);
								$tweettext= preg_replace("/#([a-z_0-9]+)/i", "<a href=\"http://twitter.com/search/$1\">$0</a>", $tweettext);
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
								$tweettext= preg_replace('/https?:\/\/[\w\-\.!~#?&=+\*\'"(),\/]+/','<a href="$0">$0</a>',$tweet1['text_en']);
								$tweettext= preg_replace("/#([a-z_0-9]+)/i", "<a href=\"http://twitter.com/search/$1\">$0</a>", $tweettext);
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
									<li><button class="btn btn-sm tags"><?php echo $tag; ?></button></li>
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
	
<?php
}
?>
