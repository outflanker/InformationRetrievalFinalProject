<?php

if(isset($_POST['query']) and !empty($_POST['query'])){
	$query = $_POST['query'];
?>
	<div class="row marketing" id="data-container">
        <div class="col-lg-4">
          <h4>Twitter</h4>
		  <?php 
				$ch=curl_init('http://outflanker.koding.io:8983/solr/project2/select?q=text_en:'.$query.'&wt=json&rows=1000');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				$result = curl_exec($ch);
				curl_close($ch);	
				$returnjson=json_decode($result,true);
				$response=$returnjson['response'];
				echo $response['numFound'];
				$i=0;
				foreach ($response['docs'] as $tweets)
				{
				?>
				<p>
				<?php
					$print=$tweets['text_en'];
					echo preg_replace('/https?:\/\/[\w\-\.!~#?&=+\*\'"(),\/]+/','<a href="$0">$0</a>',$print);
					$i++;
				?>
				</p>
				<?php
				};
			?>
        </div>

        <div class="col-lg-4">
          <h4>Facebook</h4>
          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>
          <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>
          <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
        </div>
		<div class="col-lg-4">
          <h4>Google+</h4>
          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>
          <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>
          <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
        </div>
	</div>
<?php
}
?>