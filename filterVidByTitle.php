<?php 

function filter_title($title){
	

	$filter = 'regimen,routine,staples,how to,favorites,how i,best';
	$filter_array = explode(',', $filter);

	foreach ($filter_array as $filter){
		$keyword_position = stripos($title, $filter);

		if($keyword_position){
			return true;
			break;
		} 
	
	}
		return false;
}




?>