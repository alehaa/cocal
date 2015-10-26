function cocal_encode_url() {
	// encode user and pass seperated by colon with base64 for HTML BASIC auth
	var campus_login_hash = btoa($('#cocal_user').val() + ':' + $('#cocal_pass').val());

	// generate complete URL
	var url = cocal_proxy_url + "/calendar.php?provider=" + $('#cocal_provider').val() + "&hash=" + campus_login_hash;

	// show URL in infobox
	$('#generator_url_link').attr("href", url);
	$('#generator_url_link').text(url);
	$('#generator_url').attr("class", "show");
}
