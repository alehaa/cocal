function cocal_encode_url() {
	// get CAMPUS username and password
	var campus_user = document.forms["cocal_generator"]["cocal_user"].value;
	var campus_pass = document.forms["cocal_generator"]["cocal_pass"].value;

	// encode user and pass seperated by colon with base64 for HTML BASIC auth
	var campus_login_hash = btoa(campus_user + ':' + campus_pass);

	// generate complete URL
	var campus_url = document.forms["cocal_generator"]["cocal_url"].value;
	var url = cocal_proxy_url + "/calendar.php?co=" + campus_url + "&login=" + campus_login_hash;

	// show URL in infobox
	document.getElementById("generator_url_link").href = url;
	document.getElementById("generator_url_link").innerHTML = url;
	document.getElementById("generator_url").className = "show";
}
