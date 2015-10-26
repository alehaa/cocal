<?php

/*
 * helper functions
 */

/** \brief Print an error message and exit PHP script.
 *
 * \param errno HTTP Error code.
 * \param errormsg Optional error message to be displayed in error.php.
 *
 * \return This function never returns.
 */
function error($errno, $errormsg = NULL)
{
	$err_string = array(
		400 => "Bad Request",
		500 => "Internal Server Error"
	);

	// set HTTP header for error message
	if (isset($err_string[$errno]))
		header("HTTP/1.0 $errno ".$err_string[$errno]);

	include("error.php");
	die();
}


/** \brief Reset cURL handle and set default options.
 *
 * \return Returns nothing on success. Otherwise an error message will be
 *  displayed and PHP dies.
 */
function curl_reset_handle($curl_handle)
{
	// reset cURL handle
	curl_reset($curl_handle);

	// enable cookie engine
	$options = array(
		CURLOPT_COOKIESESSION => true,
		CURLOPT_COOKIEJAR => "/dev/null"
	);

	if (!curl_setopt_array($curl_handle, $options))
		error(500, "cURL Cookie-engine konnte nicht initialisiert werden.");
}


/** \brief Perform a cURL request.
 *
 * \param curl_handle cURL handle.
 * \param url URL for request to be performed.
 * \param method HTTP request method (GET or POST).
 * \param params Optional parameters for GET and POST reqests.
 *
 * \return On success the requested data will be returned. On failure an error
 *  message will be displayed and PHP dies.
 */
function curl_request($curl_handle, $url, $method = "GET", $params = array())
{
	// reset cURL handle
	curl_reset_handle($curl_handle);

	// convert params
	$param_string = "";
	foreach($params as $key => $value)
		$param_string .= $key.'='.urlencode($value).'&';

	rtrim($param_string, '&');

	// set cURL options
	$options = array(
		CURLOPT_URL => $url,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER => true
	);

	// set params for method
	if ($method == "POST") {
		$options[CURLOPT_POST] = count($params);
		$options[CURLOPT_POSTFIELDS] = $param_string;

	} else if ($method == "GET") {
		$options[CURLOPT_URL] .= "?".$param_string;
	}

	// set all options
	if (!curl_setopt_array($curl_handle, $options))
		error(500, "cURL optionen konnten nicht gesetzt werden.");

	// execute request
	$result = curl_exec($curl_handle);
	if ($result == false)
		error(500, "Fehler bei der Kommunikation mit CAMPUS office.");

	return $result;
}



/*
 * Implementation
 */

/* Decode hash.
 * Hash is in HTML BASIC auth format base64(user:pass).
 */
if (!isset($_GET['hash']) || empty($_GET['hash']))
	error(400, "Parameter 'hash' nicht angegeben!");

$cipher = base64_decode($_GET['hash']);
if (!strpos($cipher, ':'))
	error(400, "Hash ist ung&uuml;ltig!");

list($campus_user, $campus_passwd) = explode(':', $cipher);
unset($cipher);


/* Build CAMPUS office base URL with GET variable co. Per default HTTPS is used,
 * which should not be changed. Configuration for the individual CAMPUS office
 * will be loaded from file config/<provider>.json.
 */
if (!isset($_GET['provider']))
	error(400, "Parameter 'co' nicht angegeben!");

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
