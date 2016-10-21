<?php
session_start();
define('AES_256_CBC', 'aes-256-cbc');
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
        CURLOPT_RETURNTRANSFER => true
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
function encryptUrlData($data)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(AES_256_CBC));
    $key = openssl_encrypt($data, AES_256_CBC, CRYPTPASSWORD, 0, $iv).':'.$iv;
    return base64_encode($key);
}
function decryptUrlData($data)
{
    $vars = explode(':', base64_decode($data));
    return openssl_decrypt($vars[0], AES_256_CBC, CRYPTPASSWORD, 0, $vars[1]);
}
function randomString($num) {
    $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-";
    $str = "";

    for ($i = 0; $i < $num; $i++) {
        $str .= $chars[mt_rand(0, strlen($chars) - 1)];
    }

    return $str;
}