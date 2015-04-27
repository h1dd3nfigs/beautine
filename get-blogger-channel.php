<?php

require_once 'Google/Client.php';
require_once 'Google/Service/YouTube.php';

require_once 'yt-config.php';

$client = new Google_Client();
$client->setDeveloperKey($apiKey);



// Define an object that will be used to make all API requests.
$youtube = new Google_Service_YouTube($client);

if(isset($_POST['blogger_username']) && !empty($_POST['blogger_username'])){
	  try {

		$blogger_username = $_POST['blogger_username'];
	    // Call the channels.list method to retrieve information about the
	    // channel associated with the input for blogger username.
	    $channelsResponse = $youtube->channels->listChannels('snippet,contentDetails,statistics', array(
	      'forUsername' => $blogger_username,
	    ));

	    // Only display results if at least one channel was found by that blogger_username
	    if(count($channelsResponse['items']) >= 1){
		   $htmlBody = 'Blogger Name: '. $channelsResponse['items'][0]['snippet']['title'].'<br /><br />';
		   $htmlBody .= 'Number of Subscribers: '.number_format($channelsResponse['items'][0]['statistics']['subscriberCount']).'<br /><br />';
		   $htmlBody .= '<img src="'.$channelsResponse['items'][0]['snippet']['thumbnails']['default']['url'].'">';
	   
	   // Display error message telling user to try entering a different blogger_username
	   } else{
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


?>

<!doctype html>
<html>
  <head>
    <title>Search by Username</title>
  </head>
  <body>
  	<h1>Search by Username</h1>
  	<form action="#" method="POST">
		<br />
		<input type="text" name="blogger_username" placeholder="Paste blogger username here" size="60" >
		<br /><br />
		<input type="submit" value="Search by Blogger Name">
		<br /><br />
	</form>
	<div>
		<?php if(isset($_POST['blogger_username']) 
				&& !empty($_POST['blogger_username'])): echo $htmlBody ; ?>
			<br /><br />	
			<div> 
			  	<form action="get-blogger-uploads-playlist.php" method="POST">
			  		<input type="hidden" name="blogger_username" value="<?php echo $_POST['blogger_username']; ?>">
					<input type="submit" value="Get Blogger's Uploaded Videos">
				</form>
			</div>
		<?php endif ?>
	</div>
  </body>
</html>



