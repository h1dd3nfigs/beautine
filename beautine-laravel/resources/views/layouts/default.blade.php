<?php

?>
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
				display: inline-table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.nav{
				vertical-align: top;
				text-align: right;
				padding-bottom: 20px;
			 	padding-top: 20px;
			  	padding-right: 50px;
			}

			.container {
				text-align: center;
			/*
				display: table-cell;
			*/
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
			  font-size: 96px;
			  margin-bottom: 30px;
			  color: white;
			  background-color: #B0BEC5;

			}

			.quote {
				font-size: 24px;
			}

			.how-it-works{
				font-size: 20px;
			  	text-align: left;
				padding-left: 45px;
				padding-left: 50px;
			}
			
			.form-button {
				/*
				margin-left: 20px;
				*/
				background-color: #e6e6fa;
  				font-family: Lato;
				font-size: 16px;
			}

			.form-input{
				background-color: #faebd7;
				font-family: Lato;
				font-size: 16px;
			}

			.product-list{
				font-size: 12px;
			  	text-align: left;
				padding-left: 45px;
				padding-left: 50px;
			}
			
		</style>
	</head>
	<body>
		<div class="nav">Login
		</div>
		<div class="container">
			<div class="content">
				<div class="title">Beautine</div>
				<div class="quote">
					<h2>Tracking all your bloggers' routines just got a little easier</h2>
		
					@yield('content')

				</div>
			</div>
		</div>

	</body>
</html>

