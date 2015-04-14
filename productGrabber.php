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
					'Spray',	
					'Steam',
					'Styl',
					'Thermal',
					'Treatment',
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

	$vid_txt_by_line = explode('<br />', $vid_txt);
	
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

$vid_url = 'https://www.youtube.com/watch?v=eucv7cvjIqM';
$vid_txt = get_vid_txt($vid_url);
$products = get_products_from_vid_txt($vid_txt, $buzzwords);
var_dump($products)

?>
<!--
<html>
	<head>
		<title>Beautine</title>
		
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 96px;
				margin-bottom: 40px;
			}

			.quote {
				font-size: 24px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">Beautine</div>
				<div class="quote">Keep track of your bloggers' routines</div>
			</div>
		</div>
	</body>
</html>

-->