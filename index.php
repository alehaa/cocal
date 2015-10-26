<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>CoCal</title>

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
					<li><a href="#home">Home</a></li>
					<li><a href="#security">Sicherheit</a></li>
					<li><a href="#generator">Get Calendar!</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<h1 id="home">CoCal <small>CAMPUS-Office Calender Sync Service</small></h1>
		<p>
			F&uuml;r die einfache Integration von CAMPUS-Office in deinen
			Kalender kannst du jetzt einfach den CoCal nutzen um dir den
			Kalender als iCal Kalender-Abonnement zu abonnieren. &Auml;nderungen
			im CAMPUS-Office Kalender werden sofort bei der n&auml;chsten
			Synchronisierung &uuml;bernommen. So beh&auml;ltst du immer den
			&Uuml;berblick &uuml;ber deine aktuellen Veranstaltungen.
		</p>


		<h1 id="security">Sicherheit</h1>
		<p>
			Der generierte Link ist f&uuml;r dich <b>pers&ouml;nlich</b>
			gedacht. Er enth&auml;lt deine pers&ouml;nlichen CAMPUS-Office
			Anmeldedaten und gew&auml;hrt jedem Zugriff auf deinen CAMPUS-Office
			Account. Bewahre ihn daher sicher auf, oder generiere ihn am besten
			nur, wenn du ihn gerade brauchst und schreibe ihn nicht auf.
		</p>
		<p>
			Solltest du den Link versehentlich weitergegeben haben oder ein
			Ger&auml;t mit installiertem CoCal-Abo verloren haben, so solltest
			du <b>umgehend</b> dein CAMPUS-Passwort &auml;ndern.
		</p>

		<h2>Datenschutz</h2>
		<p>
			Auf dem CoCal Server werden keine Passwort-Hashes gespeichert. Auch
			wenn von diesem Server Daten geklaut werden, kann dein Passwort also
			nicht geklaut werden.<br/>

			Wenn du dem Admin des Servers jedoch nicht traust, dass er
			sorgf&auml;ltig mit deinen Daten umgeht, kannst du CoCal auch
			einfach <a href="https://github.com/alehaa/cocal">auf deinem
			eigenen Server hosten.</a>
		</p>


		<h1 id="generator">CoCal nutzen</h1>
		<p>
			Du willst CoCal nutzen? W&auml;hle einfach deine Hochschule aus und
			trage deine CAMPUS-Anmeldedaten ein, um deine URL zu generieren.
		</p>

		<form class="form-horizontal" id="cocal_generator">
			<div class="form-group">
				<label for="cocal_url" class="col-sm-2 control-label">Hochschule</label>
				<div class="col-sm-10">
					<select class="form-control" id="cocal_provider">
<?php
$files = scandir("./config");
foreach ($files as $file) {
	if ($file[0] == '.')
		continue;

	$val = basename("./config/".$file, ".json");

	$conf = json_decode(file_get_contents("./config/".$file), true);
	if (!isset($conf['name']))
		continue;

	echo "<option value=\"$val\">".$conf['name']."</option>\n";
}
?>
					</select>
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
					<button type="submit" class="btn btn-default">URL generieren</button>
				</div>
			</div>
		</form>
		<script>
			$('#cocal_generator').submit(function () {
				cocal_encode_url();
				return false;
			});
		</script>

		<div id="generator_url" class="hidden">
			<p class="bg-info text-center cocal-url">
				Dein pers&ouml;nlicher Link f&uuml;r dein Kalender-Abonement:<br/>
				<a id="generator_url_link"></a><br/>
				<br/>
				<b>Achtung:</b> Gebe diesen Link an <b>niemanden</b> weiter, da
				er deine pers&ouml;nlichen CAMPUS-Anmeldedaten enth&auml;lt!
			</p>
		</div>

		<p>
			Den generierten Link kannst du in die meisten g&auml;ngigen
			Kalender-Programme, aber auch Online-Dienste wie Google Calendar
			als sogenanntes Kalender-Abonnement einbinden.
		</p>


		<h1 id="contribute">Mitwirken</h1>
		<p>
			CoCal wurde von <a href="http://www.steffenvogel.de">Steffen Vogel</a>
			und <a href="https://github.com/alehaa">Alexander Haase</a>
			geschrieben.
		</p>
		<p>
			Wenn du auch mit aufgelistet werden willst, ist das ganz einfach:
			CoCal ist unter der freien
			<a href="http://www.gnu.org/licenses/gpl-3.0.en.html">GPLv3</a>
			lizenziert. Das bedeutet, dass du ganz einfach &Auml;nderungen an
			CoCal vornehmen kannst, oder es nach deinen w&uuml;nschen anpassen
			kannst. Weitere Infos dazu findest du in unserem
			<a href="https://github.com/alehaa/cocal">git auf github.com</a>
		</p>
	</div>
</body>
</html>
