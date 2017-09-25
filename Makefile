# This file is part of CoCal.
#
# CoCal is free software: you can redistribute it and/or modify it under the
# terms of the GNU General Public License as published by the Free Software
# Foundation, either version 3 of the License, or (at your option) any later
# version.
#
# CoCal is distributed in the hope that it will be useful, but WITHOUT ANY
# WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
# A PARTICULAR PURPOSE. See the GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along with
# this program. If not, see
#
#  http://www.gnu.org/licenses/
#
#
# Copyright (C)
#  2011-2013 Steffen Vogel <post@steffenvogel.de>
#  2015-2017 Alexander Haase <ahaase@alexhaase.de>
#

#
# Regular targets for development.
#

all: css/main.css

css/main.css: css/main.less
	lessc css/main.less > css/main.css


#
# Target for packing a new tarball for releases.
#
.PHONY: pack
pack:
	git archive --prefix cocal/ HEAD | tar xfv -
	lessc --clean-css css/main.less > cocal/css/main.css
	uglifyjs js/cocal.js > cocal/js/cocal.js
	tar cfvz cocal.tar.gz cocal
	rm -r cocal
