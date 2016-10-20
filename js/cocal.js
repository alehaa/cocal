function cocal_encode_url() {

	if(!$('#cocal_user').val() || !$('#cocal_pass').val())
	{
		alert('Du musst einen Benutzernamen und ein Passwort angeben.')
	}
	else {
		var formData = new FormData();
		formData.append('token', $('#cocal_token').val());
		formData.append('username', $('#cocal_user').val());
		formData.append('password', $('#cocal_pass').val());

		$.ajax({
			type: "POST",
			url: cocal_proxy_url + "/generateHash.php",
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				if ('success' == data.response) {
					// retrieve generated hash
					var campus_login_hash = data.hash;

					// generate complete URL
					var url = cocal_proxy_url + "/calendar.php?provider=" + $('#cocal_provider').val() + "&v=2&pass="+ securityCode +"&hash=" + campus_login_hash;

					// show URL in infobox
					$('#generator_url_link').attr("href", url);
					$('#generator_url_link').text(url);
					$('#generator_url').attr("class", "show");
				}
				else if ('error' == data.response) {
					alert(data.message);
				}
			},
			error: function () {
				alert('Unbekannter Fehler!')
			}
		});
	}
}
