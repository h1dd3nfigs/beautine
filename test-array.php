<?php 

$vid_date = "2012-12-03T20:06:20.000Z";

$new_vid_date = date('M j, Y', strtotime($vid_date));
echo $new_vid_date;
?>