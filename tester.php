<?php
/*
* To better understand how YouTube Data API v3 works with GET requests 
* works with  GET requests, this file with make a simple request
* modeled after Example 1 at 
* https://developers.google.com/youtube/v3/getting-started
/*
*/

require_once 'yt-config.php';

define('API_KEY', $apiKey ); 

stream_context_set_default(['http' => ['ignore_errors' => true]]);

$filename = 'https://www.googleapis.com/youtube/v3/videos?id=ls1IALSUFTc&key='.API_KEY.'&part=snippet,contentDetails';

# $filename = 'https://www.googleapis.com/youtube/v3/videos?id=ls1IALSUFTc&key='.API_KEY.'&part=snippet%2CcontentDetails%2Cstatistics%2Cstatus';
//$json_response = file_get_contents($filename);

//echo $json_response ; 

$yt_sample = json_decode(file_get_contents($filename));
echo 'The video title is : <br>'.$yt_sample->{'items'}[0]->
	{'snippet'}->{'title'}.'<br><br>'.
	'The vid description is: <br>'.$yt_sample->{'items'}[0]->
	{'snippet'}->{'description'}.'<br><br>';

var_dump($yt_sample) ;
?>

