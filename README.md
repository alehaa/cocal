# CoCal

[![](https://img.shields.io/github/issues-raw/alehaa/cocal.svg?style=flat-square)](https://github.com/alehaa/cocal/issues)
[![GPL license](http://img.shields.io/badge/license-GPLv3-blue.svg?style=flat-square)](LICENSE)

The original intention of CoCal was to provide a proxy service between CAMPUS
Office servers and several devices to get an updating calendar feed. However,
recent versions of CAMPUS Office made the integration more easy. Event if it is
not officially supported yet, CoCal helps users to get the right URL to get an
updating calendar feed for their schedule.


## Installation

No special installation is required. Just unpack the packed
[release](https://github.com/alehaa/cocal/releases) into your webserver's root.

Developers using the source repository need to compile the
[main.less](css/main.less):
```
lessc css/main.less > css/main.css
```

If `make` is installed, the [Makefile](Makefile) may be used by simply running
`make`.


## Contribute

Everyone is welcome to contribute. Simply fork this repository, make your
changes *in an own branch* and create a pull-request for your changes. Please
send only one change per pull-request.

You found a bug? Please
[file an issue](https://github.com/alehaa/cocal/issues/new) and include all
information to reproduce the bug.


## License

CoCal is free software: you can redistribute it and/or modify it under the terms
of the GNU General Public License as published by the Free Software Foundation,
either version 3 of the License, or (at your option) any later version.

CoCal is distributed in the hope that it will be useful, but **WITHOUT ANY
WARRANTY**; without even the implied warranty of **MERCHANTABILITY** or
**FITNESS FOR A PARTICULAR PURPOSE**. A Copy of the GPL can be found in the
[LICENSE](LICENSE) file.

Copyright &copy; 2011-2013 [Steffen Vogel](http://www.steffenvogel.de/)<br/>
Copyright &copy; 2015-2017 [Alexander Haase](mailto:alexander.haase@rwth-aachen.de)
