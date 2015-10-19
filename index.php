<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>CoCal</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<link href="css/cocal.css" rel="stylesheet">

	<script src="js/cocal.js"></script>
	<script>
		var cocal_proxy_url = "<?php echo(((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME']); ?>";
	</script>
</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">CoCal</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="#generator">Get Calendar!</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">

		<div id="generator">
			<h1>URL generieren</h1>

			<p class="lead">
				F&uuml;lle einfach das folgende Formular aus, um deine URL zu generieren.
			</p>

			<form class="form-horizontal" id="cocal_generator">
				<div class="form-group">
					<label for="cocal_url" class="col-sm-2 control-label">Campus URL</label>
					<div class="col-sm-10">
						<input type="url" class="form-control" id="cocal_url" placeholder="campus.deineuni.de">
					</div>
				</div>
				<div class="form-group">
					<label for="cocal_user" class="col-sm-2 control-label">Benutzername</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="cocal_user" placeholder="Campus Benutzername">
					</div>

					<label for="cocal_pass" class="col-sm-2 control-label">Passwort</label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="cocal_pass" placeholder="Campus Passwort">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default" onclick="cocal_encode_url()">URL generieren</button>
					</div>
				</div>
			</form>

			<div id="generator_url" class="hidden">
				<p class="bg-info text-center cocal-url">
					Dein pers&ouml;nlicher Link f&uuml;r dein Kalender-Abonement:<br/>
					<a id="generator_url_link"></a><br/>
					<br/>
					<b>Achtung:</b> Gebe diesen Link an <b>niemanden</b> weiter, da er deine pers&ouml;nlichen CAMPUS-Anmeldedaten enhth&auml;lt!
				</p>
			</div>
		</div>

	</div>


	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
