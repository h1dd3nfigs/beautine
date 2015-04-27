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
//	$vid_txt_by_line = explode('<br />', $vid_txt);
	$vid_txt_by_line = explode("\n", $vid_txt_after_products);
	//	print_r($vid_txt_by_line);
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

//if(isset($_POST['vid_url']) && !empty($_POST['vid_url'])) 
//{
//	$vid_url = $_POST['vid_url'];
//	$vid_txt = get_vid_txt($vid_url);
	$vid_txt =  "THUMBS ME UP IF YOU WOULD LIKE TO SEE A DEMO OF THIS PRODUCT! :) *I created this video to share my experience and how well this product worked for my hair! If you have tried this product or any Lush products comment below and tell me about them.*\n\nLush Fresh Handmade Cosmetics - http://www.lush.com\nLust - Zeste Medium to Strong Hair Gelly\n\nWant to see what I use to achieve moisturized hair? Watch here -bit.ly/UdRgrX\n\nWatch how I moisturize and seal - http://bit.ly/1nQXfjc\n\nWatch how my bun tutorial - http://bit.ly/1kDV9A5\n\nFoundation Routine - http://bit.ly/1p8KOfZ\n\nFollow Me Around\nInstagram - ulovemegz\nTwitter - http://www.twitter.com/ulovemegz\nFacebook - http://www.facebook.com/ulovemegz\nBlogger - http://www.ulovemegz.com\nBusiness Contact - ulovemegzbusiness@gmail.com";
	$products = get_products_from_vid_txt($vid_txt, $buzzwords);
	var_dump($products);

//}

?>
<form action="#" method="POST">
	<br />
	<input type="text" name="vid_url" placeholder="Paste video URL here" width=200>
	<br /><br />
	<input type="submit" value="Retrive Product List">

</form>
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