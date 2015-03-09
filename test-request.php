<?php
/*
* To better understand how YouTube Data API v3 works with GET requests 
* works with  GET requests, this file with make a simple request
* modeled after Example 1 at 
* https://developers.google.com/youtube/v3/getting-started
* This file will be hosted at beautine.elxr.it which hopefully satisfies
* the requirements of mine being a client API key associated with *.elxr.it/*
*/ 

stream_context_set_default(['http' => ['ignore_errors' => true]]);

$filename = 'https://www.googleapis.com/youtube/v3/videos?id=ls1IALSUFTc&key=&part=snippet';

# $filename = 'https://www.googleapis.com/youtube/v3/videos?id=ls1IALSUFTc&key=&part=snippet%2CcontentDetails%2Cstatistics%2Cstatus';
echo $filename.'<br><br>';
$json_response = file_get_contents($filename);

$yt_sample = json_decode($json_response);

//echo 'Triumph<br>';
//var_dump($yt_sample);
var_dump($yt_sample) ;
//echo $json_response ; 
