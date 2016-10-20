<?php
require_once('includes.php');
if (file_exists('config.php') && file_exists('install.php')) {
    error(500, "Vor dem Benutzen von Cocal muss die install.php file gelöscht werden.");
}
else if (!file_exists('config.php')) {
    error(500, "Vor dem Benutzen von Cocal muss Cocal <a href='install.php'>installiert werden</a>.");
}
require_once('config.php');
header('Content-Type: application/json');
$response = "error";
$message = "";
$hash = "";
if(!isset($_POST['token']) || empty($_POST['token'])) {
    $message = "Fehler! Lehre Anfrage.";
}
else if($_POST['token'] != $_SESSION['cocalRequestToken']) {
    $message = "Fehler! Die Anfrage wurde sicherheitshalber nicht angenommen.";
}
else if(empty($_POST['username']) || empty($_POST['password'])) {
    $message = "Fehler! Die Anfrage war nicht vollständig.";
}
else {
    $response = "success";
    $hash = encryptUrlData($_POST['username'] . ':' . $_POST['password']);
}
echo json_encode(array(
    'response' => $response,
    'message' => $message,
    'hash' => $hash
    ));