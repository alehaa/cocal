# CoCal

CoCal ist ein Calender Sync Service für CAMPUS-Office. Mithilfe von CoCal kann der CAMPUS-Office Kalender einfach in jede Anwendung integriert werden, die das iCal Format unterstüzt. So entfallen lästige manuelle Synchronisationen mit CAMPUS-Office.


## Einrichtung

CoCal benötigt einen Webserver mit PHP sowie deren cURL-Erweiterung. Alles weitere ist in diesem Repository enthalten.

CoCal muss nicht gesondert eingerichtet werden. Lade es einfach in das Verzeichnis deines Webservers und du kannst loslegen.


### nginx-Konfiguration

Bei der Einrichtung deines vHosts für CoCal solltest du zwei Dinge beachten:

1. Nutze TLS! Bei jeder Synchronisation werden Anmeldedaten übergeben, also solltest du die Daten deiner Benutzer entsprechend absichern. Eine Nutzung über unverschlüsseltes HTTP solltest du nicht anbieten.
2. Schalte das Logging für URL-Parameter ab! Die Anmeldedaten werden als URL-Parameter übergeben, also sollten diese nicht in irgendwelchen Logs abgespeichert sein.

Eine Beispielkonfiguration für einen vHost:

```
log_format cocal '$remote_addr - $remote_user [$time_local] '
	'"$request_method $uri" $status $body_bytes_sent '
	'"$http_referer" "$http_user_agent"';

server {
	# listen on all IPv4 and IPv6 interfaced on port 443
	listen 443;

	# the name of our subdomain
	server_name cocal.example.com;

	# Logging
	# The query parameters must not be logged, because they
	# include the username and password of the users.
	access_log /var/log/nginx/cocal/access.log cocal;
	error_log /var/log/nginx/cocal/error.log;

	# TLS settings
	ssl on;
	ssl_certificate /etc/ssl/localcerts/cocal.pem;
	ssl_certificate_key /etc/ssl/private/cocal.key;


	# root directory of webserver
	root /srv/www/cocal;

	# index sites & autoindex
	index index.html index.htm index.php;
	autoindex on;

	# fastcgi settings
	location ~ .php$ {
		fastcgi_pass unix:/var/run/php5-fpm.sock;
		fastcgi_index index.php;
		include fastcgi_params;
	}
}
```


## Mitwirken

Wenn du an CoCal mitwirken willst, kannst du dieses Repository einfach klonen und Änderungen als Pull-Request einreichen.

Falls du das CAMPUS-Office deiner Universität hinzufügen möchtest, musst du lediglich eine JSON-Datei im Ordner ```config``` anlegen, welche das folgende Format hat:
```JSON
{
	"name": "Name der Universität",
	"login": {
		"username": "ID des Username-Feldes in der Anmeldemaske",
		"password": "ID des Passwort-Feldes in der Anmeldemaske",
		"login": {
			"label": "ID des Login-Buttons in der Anmeldemaske",
			"value": "Value des Login-Buttons in der Anmeldemaske"
		},
		"url": "URL der Anmelseite"
	},
	"calendar": "URL des Kalenders"
}
```


## Lizenz

CoCal ist unter der freien [GPLv3](http://www.gnu.org/licenses/gpl-3.0.en.html) lizenziert.


## Copyright

Copyright 2011-2015 [Steffen Vogel](http://www.steffenvogel.de/)
Copyright 2015 [Alexander Haase](mailto:alexander.haase@rwth-aachen.de)
