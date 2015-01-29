<?php 
/*
* The goal of the Beautine application is to provide an input field
* where the user can type the name of a YouTube guru and then have 
* application output which products this guru is using for her hair
* nails and skin. To accomplish this task, the application is making 
* a request to the YT API for a channel and it's videos, for any 
* videos that have products listed in the description box, we display
* those products by in the appropriate hair, nails , skin list on 
* beautine's site. Of course, we'd want the products to be those  
* that are part of the guru's routine, rather than just a product 
* she happens to be reviewing, either paid to review or just curious

* At the suggestion of HackerSchool, I laid out the build goals for
* working each of the time durations
* 1 HOUR - text only


* 1 DAY - text & YT user thumbnail

* 2 DAYS - text, YT user thumbnail & product image from google/amazon
video ID uS3-x_2IGHs
*/
?>

<form action="beautine.php" method=POST>
	Enter the name of YouTube guru:
	<input type="text" name="yt_username" maxlength=60 ><br><br>

	OR <br><br>

	Enter the video ID :
	<input type="text" name="yt_vid_id" maxlength=20 ><br><br>
	<input type="submit" value="Get your guru's beautine">
</form>

<?php

// Check that form has been submitted & field is not empty before displaying yt info
if(isset($_POST['yt_username'])){
	if (!empty($_POST['yt_username'])||!empty($_POST['yt_vid_id'])){
	
	// Assign the user-supplied YT guru's username to a variable that is fed into the GET request
	$yt_username = $_POST['yt_username'];
	$yt_vid_id = $_POST['yt_vid_id'];

/*	// Choose which GET request to make based on whether the user entered a YT username or video ID
	if($yt_username==''){

		$json_feed = file_get_contents('https://gdata.youtube.com/feeds/api/videos/'.$yt_vid_id.'?v=2&alt=json');

	} else {

		// Read the entire json file into a string
		// Assign said string to the variable named $json_feed
		$json_feed = file_get_contents("https://gdata.youtube.com/feeds/api/users/".$yt_username."?v=2.1&alt=json");
	}
*/
	$json_feed = file_get_contents('https://gdata.youtube.com/feeds/api/videos/'.$yt_vid_id.'?v=2&alt=json');
	
	// Take the JSON encoded string named $json_feed and convert it into a PHP variable named $yt_list
	$yt_list = json_decode( $json_feed);

	// Display info about the variable $yt_list, including its type and value
/*	echo 'The video title : <br>'.$yt_list->{'entry'}->{'title'}->{'$t'}.'<br><br>';

	echo 'The description box : 
		<br>'.$yt_list->{'entry'}->{'media$group'}->{'media$description'}->{'$t'};
*/
	var_dump($yt_list);

	} else { // elseif empty($_POST) 

		echo '*Both username and video ID cannot be blank. Please enter one.';
	}

} //endif isset($_POST)
