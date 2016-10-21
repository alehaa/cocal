<?php
require_once('includes.php');
if (file_exists('config.php') && file_exists('install.php')) {
	error(500, "Vor dem Benutzen von Cocal muss die install.php file gelöscht werden.");
}
else if (!file_exists('config.php')) {
	error(500, "Vor dem Benutzen von Cocal muss Cocal <a href='install.php'>installiert werden</a>.");
}
require_once('config.php');
/*
 * Implementation
 */

/* Decode hash.
 * Hash is encrypted by encryptUrlData().
 */
if ($_GET['v'] == 2 && (!isset($_GET['pass']) || empty($_GET['pass']) || $_GET['pass'] != URLPASSWORD))
{
	error(400, "Security code Falsch!");
}
if (!isset($_GET['hash']) || empty($_GET['hash']))
	error(400, "Parameter 'hash' nicht angegeben!");

if($_GET['v'] == 2) {
	$cipher = decryptUrlData($_GET['hash']);
}
else {
	$cipher = base64_decode($_GET['hash']);
}
if (!strpos($cipher, ':'))
	error(400, "Hash ist ung&uuml;ltig!");

list($campus_user, $campus_passwd) = explode(':', $cipher);
unset($cipher);


/* Build CAMPUS office base URL with GET variable co. Per default HTTPS is used,
 * which should not be changed. Configuration for the individual CAMPUS office
 * will be loaded from file config/<provider>.json.
 */
if (!isset($_GET['provider']))
	error(400, "Parameter 'provider' nicht angegeben!");

$config = json_decode(file_get_contents("./config/".$_GET['provider'].".json"),
                      true);
if (!is_array($config) || empty($config))
	error(500, "Konfiguration konnte nicht geladen werden.");


// init cURL handle.
$ch = curl_init();
if ($ch == false)
	error(500, "cURL konnte nicht initialisiert werden.");



/* Login user in CAMPUS office. This login may differ from site to site, so this
 * login is specific for the FH Aachen University of applied sciences.
 */
$login = array(
	$config['login']['username'] => $campus_user,
	$config['login']['password'] => $campus_passwd,
	$config['login']['login']['label'] => $config['login']['login']['value']
);

curl_request($ch, $config['login']['url'], "POST", $login);

/* Request calendar.
 * Default timeslot is 1 week in past and half year in future.
 */
date_default_timezone_set("Europe/Berlin");
$calParams = array(
	"startdt" => strftime("%d.%m.%Y", time() - 7*24*60*60),
	"enddt"   => strftime("%d.%m.%Y %H:%M:%S", time() + 6*31*24*60*60)
);

$calendar = curl_request($ch, $config['calendar'], "GET", $calParams);

// print calendar
header("Content-type: text/calendar; charset=utf-8");
header("Content-Disposition: inline; filename=calendar.ics");
echo($calendar);

?>
