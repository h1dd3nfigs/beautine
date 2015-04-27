<?php namespace App\RFlib ;

require_once 'Google/Client.php';
require_once 'Google/Service/YouTube.php';
//require_once 'yt-config.php';
use App\RFlib\YTConfig ;

class MyYouTubeAPILibrary{
/*
	MyYouTubeAPILibrary	class contains methods to handle YT API calls
*/

	public function __construct(YTConfig $ytconfig)
	{

		$client = new \Google_Client() ;
		$client->setDeveloperKey($ytconfig->apiKey);

		// Define an object that will be used to make all API requests.
		$this->youtube = new \Google_Service_YouTube($client);
	}

	public function getBloggerChannel($username)
	{
		// return name of blogger's channel, her pic & other summary info 

		try {
			// Call the channels.list method to retrieve information about the
			// channel associated with the paramter $username .
			$channelsResponse = $this->youtube->channels->listChannels('snippet,contentDetails,statistics', 
																 array('forUsername' => $username,
																 ));

			// Only display results if at least one channel was found by that username
			if(count($channelsResponse['items']) >= 1){
			   
			   $channel_summary = array(
										'blogger_username'	=>$channelsResponse['items'][0]['snippet']['title'],
										'subscriber_count'	=>number_format($channelsResponse['items'][0]['statistics']['subscriberCount']),
										'blogger_pic'		=>$channelsResponse['items'][0]['snippet']['thumbnails']['default']['url'],
										'uploads_list_id'	=>$channelsResponse['items'][0]['contentDetails']['relatedPlaylists']['uploads'],
								        'video_count' 		=> number_format($channelsResponse['items'][0]['statistics']['videoCount']),
										);

				return $channel_summary ;

			// Display error message telling user to try entering a different blogger_username
			} else {
				
				echo 'Error:<br />There was a problem locating a blogger by that username. Please try another username.';

			}

		} catch (Google_ServiceException $e) {
			
			$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
		  	htmlspecialchars($e->getMessage()));
		
		} catch (Google_Exception $e) {
			
			$htmlBody .= sprintf('<p>A client error occurred: <code>%s</code></p>',
			htmlspecialchars($e->getMessage()));
		}
	}


	public function getChannelUploads($uploadsListId)
	{
		// return $uploaded_vids 
		try
		{

	    
	    $nextPageToken = '';
	    $uploaded_vids = '';
	       
	      // Extract the unique playlist ID that identifies the list of videos
	      // uploaded to the channel, and then call the playlistItems.list method
	      // to retrieve that list.
	        
  		    $playlistItemsResponse = $this->youtube->playlistItems->listPlaylistItems('snippet', array(
		        'playlistId' => $uploadsListId,
		        'maxResults' => 50, 
		        'pageToken' => $nextPageToken
	        ));

	        $all_titles = array();
	        $uploaded_vids = array();

	        foreach ($playlistItemsResponse['items'] as $playlistItem) {
	        	$vid_number = $playlistItem['snippet']['position'];
	        	$vid_title = $playlistItem['snippet']['title'];
	        	$vid_id =  $playlistItem['snippet']['resourceId']['videoId'];
	        	$vid_img_url = $playlistItem['snippet']['thumbnails']['default']['url'];
		        $vid_date =  date('M j, Y', strtotime($playlistItem['snippet']['publishedAt']));
		      	$vid_txt = $playlistItem['snippet']['description'];

	        	$all_titles[]= $vid_title ;

		        
		      	// grab the products mentionned in the description under each vid (playlistItem)
		      	$products = $this->grabProductsFromVid($vid_txt);
		      	
				$uploaded_vids[] = array(					  
		        						'vid_number'   => $vid_number,
		        						'vid_title'    => $vid_title, 
		        						'vid_id'	   => $vid_id,
										'vid_img_url'  => $vid_img_url,
		        						'vid_date'	   => $vid_date, 
		        						'vid_products' => $products,
									);
		      

	      	}

	      	// apply filter to remove all videos with irrelevant titles
	      	 $filtered_titles = $this->filterUploadsByTitle($all_titles);
	      	 echo 'Filtered Titles: <br />';
	      	 var_dump($filtered_titles);
	      	 echo 'All Titles: <br />';
	      	 var_dump($all_titles);
	      	 die;
	      	 //return var_dump($uploaded_vids) ;
	      	/*
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
		      	$products = grabProductsFromVid($vid_txt, $buzzwords);
		      	$htmlBody .= '<ul>';

	      		foreach($products as $product){
					$htmlBody .= '<li>'.$product.'</li>';
	      		}

		    $htmlBody .= '</ul><br /><br />';  
	        $nextPageToken = $playlistItemsResponse['nextPageToken'];

	     } //endfor $nextPageToken
	      $htmlBody .= '</ul>';  

	  	}
		    
   */

	  } catch (Google_ServiceException $e) {
	    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
	      htmlspecialchars($e->getMessage()));
	  } catch (Google_Exception $e) {
	    $htmlBody .= sprintf('<p>A client error occurred: <code>%s</code></p>',
	      htmlspecialchars($e->getMessage()));
	  }

 
	}

	public function filter_title($title){
		

		$keyword = 'regimen,routine,staples,favorites';
		$filter_array = explode(',', $keyword);

		foreach ($filter_array as $filter){
			$keyword_position = stripos($title, $filter);

			if($keyword_position !== false){
				return true;
				break;
			} 
		
		}
			return false;
	}



	public function filterUploadsByTitle($all_titles)
	{
		// return $filtered_vid_titles 
		$filtered_vid_titles = array_filter($all_titles, array($this,"filter_title"));
		return $filtered_vid_titles ;
	}




	public function grabProductsFromVid($vid_txt)
	{
		//return $products 
		$buzzwords = array(
					'Activator',
					'Balm',
					'Bottle',	
					'Brush',
					'Butter',	
					'Comb',
					'Cholestorol',	
					'Conditioner',	
					'Cream',	
					'Creme',
					'Curl',
					'Custard',
					'Detangl',
					'Edge',	
					'Gel',	
					'Heat',
					'Humid',
					'Hydrat',
					'Keratin',	
					'Leave-in',
					'Lotion',
					'Maker',
					'Mask',
					'Masque',	
					'Mayo',
					'Moist',
					'Oil',
					'Paste',	
					'Pre-poo',
					'Prepoo',
					'Protein',	
					'Pudding',	
					//'Rod',
					'Reconstructor',
					'Relaxer',
					'Rinse',	
					'Roller',
					'Scalp',	
					'Serum',	
					'Shampoo',
					'Slick',
					'Silk',
					'Smooth',
					'Soap',
					'Solution',	
					'Spray',	
					'Steam',
					//'Styl',
					'Thermal',
					'Treatment',
					'Wash',
		);
		$products = array();
		$vid_txt_by_line = explode("\n", $vid_txt);
		foreach ($vid_txt_by_line as $line) 
		{
			foreach ($buzzwords as $buzzword) 
			{
				if (stripos($line, $buzzword) !== false) 
				{
						$products[] = $line ;
						break 1;
				}
			}
		}
		return $products ;
	}


}