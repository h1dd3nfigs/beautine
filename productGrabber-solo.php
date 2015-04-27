<?php 

/*
	//... Grab text blob from vid description-- if need be, write web data parsing script using file_get_contents() and pregmatch() on HTML source code from YT page STARTING AT <div id="watch-description-text" class=""><p id="eow-description" > ENDING AT the first appearance of </p></div>
	//.. Split text blob into array where each newline is a substring
	//.. Create list of buzzwords
	//.. Create empty products array to store products found in text blob
	//.. Loop through each line of text blob 
	//.. if any elements from buzzwords list appear asa  substring of that line
	//.. then add that entire line as an element in the products array
*/

/*
	$data = file_get_contents($vid_url);
	$regex = '/span id="eow-title" class="watch-title " dir="ltr" title="\S+(.*)?/';
	preg_match($regex, $data, $matches);
	var_dump($matches); 
*/

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
					'Rod',
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


function get_vid_txt($vid_url)
{
	$data = file_get_contents($vid_url);

	$start_flag = 'watch-description-text" class=""><p id="eow-description" >';

	$first_substr = substr($data, strpos($data, $start_flag) + strlen($start_flag));


	$second_substr =strstr($first_substr, '</p>', TRUE);
	
	return $second_substr;

}


function get_products_from_vid_txt($vid_txt, $buzzwords)
{
	$products = array();
	$vid_txt_after_products = stristr($vid_txt, "products");
	$vid_txt_by_line = explode('<br />', $vid_txt_after_products);

	foreach ($vid_txt_by_line as $line) 
	{
		foreach ($buzzwords as $buzzword) {
	
			if (stripos($line, $buzzword) !== false) 
				{
					$products[] = $line ;
					break 1;
				}
		}
	}
	return $products ;
}

if(isset($_POST['vid_url']) && !empty($_POST['vid_url'])) {
	$vid_url = $_POST['vid_url'];
	$vid_txt = get_vid_txt($vid_url);

	$products = get_products_from_vid_txt($vid_txt, $buzzwords);
	var_dump($products);
}

?>
<html>
<head>
	<title>Product Grabber</title>
</head>
<body>
	<h2>Product Grabber</h2>
	<form action="#" method="POST">
		<br />
		<input type="text" name="vid_url" placeholder="Paste video URL here" width="200">
		<br /><br />
		<input type="submit" value="Retrieve Product List">

	</form>
</body>
</html>