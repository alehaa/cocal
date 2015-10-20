<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Fehler | CoCal</title>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- CoCal -->
	<link href="css/cocal.css" rel="stylesheet">
</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php#">CoCal</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="index.php#generator">Get Calendar!</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">

		<div id="generator">
			<h1>Fehler</h1>

			<p class="lead">
				Bei deiner Anfrage ist ein Fehler aufgetreten.<br/>
				Bitte korrigiere deine Anfrage, oder <a href="index.php#generator">generiere eine neue URL</a>.
			</p>

			<?php if (isset($errormsg)) { ?>
			<p class="bg-danger cocal-url">
				<?php echo($errormsg); ?>
			</p>
			<?php } ?>
		</div>

	</div>
</body>
</html>
