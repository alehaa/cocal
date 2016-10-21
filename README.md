# CoCal

CoCal ist ein Calender Sync Service für CAMPUS-Office. Mithilfe von CoCal kann der CAMPUS-Office Kalender einfach in jede Anwendung integriert werden, die das iCal Format unterstüzt. So entfallen lästige manuelle Synchronisationen mit CAMPUS-Office.


## Einrichtung

CoCal benötigt einen Webserver mit PHP sowie deren cURL-Erweiterung. Alles weitere ist in diesem Repository enthalten.

CoCal muss zusätzlich noch installiert werden um einen Verschlüsselungs-Key zu generieren. Lade es einfach in das Verzeichnis deines Webservers und öffne die Seite ```install.php``` in einem Browser und klicke dort auf den Install-Button.
Nach der Installation muss die Installations-Datei noch gelöscht werden und schon kannst du Cocal benutzen.

Beachte, dass PHP genügend Rechte hat, um im Hauptverzeichnis Dateien anzulegen und hinein zu schreiben. Dies ist notwendig, damit die Config-File angelegt werden kann.


### nginx-Konfiguration

Bei der Einrichtung deines vHosts für CoCal solltest du zwei Dinge beachten:

1. Nutze TLS! Bei jeder Synchronisation werden Anmeldedaten übergeben, also solltest du die Daten deiner Benutzer entsprechend absichern. Eine Nutzung über unverschlüsseltes HTTP solltest du nicht anbieten.
2. Schalte das Logging für URL-Parameter ab! Die Anmeldedaten werden als URL-Parameter übergeben, also sollten diese nicht in irgendwelchen Logs abgespeichert sein.

Zudem solltest du die IP der Nutzer anonymisieren oder gar nicht loggen, da dies sonst gegen §15 TMG verstößt.

Eine Beispielkonfiguration für einen vHost:

```
# Log format for CoCal
#
# URL params will not be logged, thus they include user authentication
# data, which should not be in logs.
#
log_format cocal '$remote_addr_anonym [$time_local] "$request_method $uri" '
	'$status $body_bytes_sent "$http_user_agent"';

# Rate limiting
#
# To avoid users to abuse this service, only one request per minute
# should be allowed for calendar.php.
#
limit_req_zone $binary_remote_addr zone=cocal:1m rate=1r/m;


server {
	# listen on all IPv4 and IPv6 interfaced on port 443
	listen 443;

	# the name of our subdomain
	server_name cocal.example.com;


	# Logging
	#
	# Last byte of IPv4 will be truncated.
	if ($remote_addr ~ (\d+).(\d+).(\d+).(\d+)) {
		set $remote_addr_anonym $1.$2.$3.0;
	}

	access_log off;
	error_log /var/log/nginx/campus/error.log;

	# favicon.ico
	location = /favicon.ico {
		log_not_found off;
		access_log off;
	}

	# robots.txt
	location = /robots.txt {
		allow all;
		log_not_found off;
		access_log off;
	}


	# TLS settings
	ssl on;
	ssl_certificate /etc/ssl/localcerts/cocal.pem;
	ssl_certificate_key /etc/ssl/private/cocal.key;


	# root directory of webserver
	root /srv/www/cocal;

	# index sites & autoindex
	index index.html index.htm index.php;
	autoindex on;


	# apply rate limiting
	location ~ /calendar.php {
		limit_req zone=cocal burst=3;

		fastcgi_pass unix:/var/run/php5-fpm.sock;
		fastcgi_index index.php;
		include fastcgi_params;

		access_log /var/log/nginx/campus/access.log cocal;
	}


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

Copyright 2016 [Loïc Beurlet](https://github.com/Lozik)
