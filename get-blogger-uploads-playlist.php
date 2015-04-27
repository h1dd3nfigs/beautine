<?php

require_once 'Google/Client.php';
require_once 'Google/Service/YouTube.php';

require_once 'yt-config.php';

$client = new Google_Client();
$client->setDeveloperKey($apiKey);

//include 'get-blogger-channel.php';
include 'productGrabber.php';
include 'filterVidByTitle.php';
// Define an object that will be used to make all API requests.
$youtube = new Google_Service_YouTube($client);

if(isset($_POST['blogger_username']) && !empty($_POST['blogger_username'])){
	
	try{

	    // Call the channels.list method to retrieve information about the
	    // channel associated with the input for blogger username.
		$blogger_username = $_POST['blogger_username'];

	    $channelsResponse = $youtube->channels->listChannels('snippet,contentDetails,statistics', array(
	      'forUsername' => $blogger_username,
	    ));

	    $nextPageToken = '';
	    $htmlBody = '';
	    $htmlBody .= 'Blogger Name: '. $channelsResponse['items'][0]['snippet']['title'].'<br /><br />
			    	Number of Subscribers: '.number_format($channelsResponse['items'][0]['statistics']['subscriberCount']).'<br /><br />
			    <img src="'.$channelsResponse['items'][0]['snippet']['thumbnails']['default']['url'].'">';
		   
	    foreach ($channelsResponse['items'] as $channel) {
	      // Extract the unique playlist ID that identifies the list of videos
	      // uploaded to the channel, and then call the playlistItems.list method
	      // to retrieve that list.
	        $videoCount = number_format($channel['statistics']['videoCount']);
	     
	        $bloggerName = $channel['snippet']['title'];
	     
	        $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
		 
  		    $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
		        'playlistId' => $uploadsListId,
		        'maxResults' => 50, 
		        'pageToken' => $nextPageToken
	        ));

	        $htmlBody .= "<h3>$videoCount Videos uploaded by $bloggerName</h3><ul>";
		     
		     $all_titles = array();
	        	
	        foreach ($playlistItemsResponse['items'] as $playlistItem) {
	        	$vid_title = $playlistItem['snippet']['title'];
	        	$vid_number = $playlistItem['snippet']['position'];
	        	$vid_id =  $playlistItem['snippet']['resourceId']['videoId'];
	        	$vid_img_url = $playlistItem['snippet']['thumbnails']['default']['url'];
		        $vid_date =  date('M j, Y', strtotime($playlistItem['snippet']['publishedAt']));
	        	$all_titles[$vid_id]= $vid_title ;

		        $htmlBody .= sprintf('<li>Video Number %s: %s (%s)</li><img src="%s">',
					        		$vid_number, $vid_title, $vid_date, $vid_img_url);
		      
		      	// grab the products mentionned in the description under each vid (playlistItem)
		      	$vid_txt = $playlistItem['snippet']['description'];
		      	$products = get_products_from_vid_txt($vid_txt, $buzzwords);
		      	$htmlBody .= '<ul>';

	      		foreach($products as $product){
					$htmlBody .= '<li>'.$product.'</li>';
	      		}

			    $htmlBody .= '</ul><br /><br />';  

	      	}
  	      $nextPageToken = $playlistItemsResponse['nextPageToken'];
	      $pages = $videoCount/50 - 1;
	      for ($i=0; $i < $pages ; $i++) { 
	     	//RE-RUN playListItems.list for the next 50 results
	     	$playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
		        'playlistId' => $uploadsListId,
		        'maxResults' => 50, 
		        'pageToken' => $nextPageToken
	        ));

	        $htmlBody .= "<h3>$videoCount Videos uploaded by $bloggerName</h3><ul>";
	     
	        foreach ($playlistItemsResponse['items'] as $playlistItem) {
	        	
	        	$vid_title = $playlistItem['snippet']['title'];
	        	$vid_number = $playlistItem['snippet']['position'];
	        	$vid_id =  $playlistItem['snippet']['resourceId']['videoId'];
	        	$vid_img_url = $playlistItem['snippet']['thumbnails']['default']['url'];
		        $vid_date =  date('M j, Y', strtotime($playlistItem['snippet']['publishedAt']));

	        	$all_titles[$vid_id]= $vid_title ;

		        $htmlBody .= sprintf('<li>Video Number %s: %s (%s)</li><img src="%s">',
					        		$vid_number, $vid_title, $vid_date, $vid_img_url);
		      
		      	// grab the products mentionned in the description under each vid (playlistItem)
		      	$vid_txt = $playlistItem['snippet']['description'];
		      	$products = get_products_from_vid_txt($vid_txt, $buzzwords);
		      	$htmlBody .= '<ul>';

	      		foreach($products as $product){
					$htmlBody .= '<li>'.$product.'</li>';
	      		}

		    $htmlBody .= '</ul><br /><br />';  
	        $nextPageToken = $playlistItemsResponse['nextPageToken'];

	     } //endfor $nextPageToken
	      $htmlBody .= '</ul>';  

	  	}}
		    
   

	  } catch (Google_ServiceException $e) {
	    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
	      htmlspecialchars($e->getMessage()));
	  } catch (Google_Exception $e) {
	    $htmlBody .= sprintf('<p>A client error occurred: <code>%s</code></p>',
	      htmlspecialchars($e->getMessage()));
	  }

} else {

      	echo 'blogger_username is not set.';
}


?>


<!doctype html>
<html>
  <head>
    <title>Blogger Uploads List</title>
  </head>
  <body>
   	<h1>Blogger Uploads List</h1>
<!--
  	<form action="#" method="POST">
		<br />
		<input type="text" name="blogger_username" placeholder="Paste blogger username here" size="60" >
		<br /><br />
		<input type="submit" value="Search by Blogger Name">
	</form>
-->

<!--
	// Call array_filter() all titles, with callback filter_titles()
	// if no keywords are present in the title, 
	//remove that vid title from array $titles
-->
	<div><?php 
			//var_dump($all_titles);
			var_dump(array_filter($all_titles, "filter_title")); 
		?>
	</div>
	<div><?= $htmlBody ?></div>
	<?php
	// if(isset($_POST['blogger_username']) && !empty($_POST['blogger_username'])): echo $htmlBody ; 
	?>
    <?php 
    //endif 
    ?>

  </body>
</html>



