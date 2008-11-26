#!/bin/bash

## 
## +----------------------------------------------------------------------+
## | Automne (TM)                                                         |
## +----------------------------------------------------------------------+
## | Copyright (c) 2000-2005 WS Interactive                               |
## +----------------------------------------------------------------------+
## | This source file is subject to version 2.0 of the GPL license,       |
## | or (at your discretion) to version 3.0 of the PHP license.           |
## | The first is bundled with this package in the file LICENSE-GPL, and  |
## | is available at through the world-wide-web at                        |
## | http://www.gnu.org/copyleft/gpl.html.                                |
## | The later is bundled with this package in the file LICENSE-PHP, and  |
## | is available at through the world-wide-web at                        |
## | http://www.php.net/license/3_0.txt.                                  |
## +----------------------------------------------------------------------+
## | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
## +----------------------------------------------------------------------+
##
## $Id: cms-reset-files-perms.sh,v 1.1.1.1 2008/11/26 17:12:35 sebastien Exp $

##
## Administration scripts
## 
## Reset all Automne websites files permissions
## Run from website $DOCUMENT_ROOT as ./automne_bin/adm-reset-files-perms.sh
## 

# Check
if [ ! -d "automne" ]; then
	echo ""
	echo "  [EE] Verifiy you run this script from an Automne website root directory"
	exit 1
fi

## +----------------------------------------------------------------------+
## | Vars and Parameters                                                  |
## +----------------------------------------------------------------------+

##
## User and/or group website belongs to (Will read, write, execute some selected files)
## Apache must be either the user or at least in given group
## Leave blank and no `chown` command will be applied, skipped
##
DEFAULT_USER=""
DEFAULT_GROUP=""

##
## List of chmod users allowed to write/read/execute selected administration files
## Apache must be either the user or at least in group
## This var will be used in a command such like : `chmod $DEFAULT_CHMOD_LIST+rwx my_file`
##
DEFAULT_CHMOD_LIST="ug"

##
## Set to true if you want all files and dirs
## write/execute protected before applying any specific needed right
## Useful when setting online, not for local development
## 
SECURE_FILES_AND_DIRS=0

##
## System executables
##
BIN_GREP="/bin/grep"
BIN_CHMOD="/bin/chmod"
BIN_CHOWN="/bin/chown"

## External sources and functions
## Use external file to get main constants and funcs
FUNCS_FILE="./automne_bin/cms-constants.sh"
if [ ! -f ${FUNCS_FILE} ]; then
	echo ""
	echo " [EE] File not found : ${FUNCS_FILE} "
	echo "      Be sure to run this from Automne website root dir"
	exit 1
else
	source ${FUNCS_FILE}
fi

##
## This file contains all default or minimal permissions
## necessary for Automne to run properly
## Default ./automne/classes/scripts/automneChmod.txt (this script is
## run from server $DOCUMENT_ROOT
##
AUTOMNE_PERMISSIONS_FILE="./automne/classes/scripts/automneChmod.txt"
if [ ! -f ${AUTOMNE_PERMISSIONS_FILE} ] ; then
	echo ""
	echo " [EE] File not found : ${AUTOMNE_PERMISSIONS_FILE} "
	echo "      Be sure to run this from a recent Automne website"
	exit 1
fi

## 
## Getting vars from script parameters
## And proceed to some tests
while getopts ":qsu:g:h" opt; do
	case $opt in
		s ) SECURE_FILES_AND_DIRS=1;;
		g ) DEFAULT_GROUP="${OPTARG}";;
		u ) DEFAULT_USER="${OPTARG}";;
		q ) QUIET=true;;
		h ) echo ""
			echo "  [USAGE]: $0 [-qs] [-u user] [-g group]"
			echo "      -q :  Script keeps quiet, except for errors"
			echo "      -u :  User to chown with"
			echo "      -g :  Group to chown with"
			echo "      -s :  Force securization setting all data read-only first"
			echo ""
			exit 1;;
		\? ) QUIET=false;;
	esac
done
shift $(($OPTIND - 1))

## +----------------------------------------------------------------------+
## | Runs                                                                 |
## +----------------------------------------------------------------------+

print " + Updating Automne website files owners and/or permis"

##
## Defines user and/or group files owners
##
if [ "${DEFAULT_USER}" != "" ]; then
	USERS=${DEFAULT_USER}
	if [ "${DEFAULT_GROUP}" != "" ]; then
		USERS="${USERS}:${DEFAULT_GROUP}"
	fi
fi
if [ "${USERS}" != "" ]; then
	print ""
	print "  ++ Owners of all files changed for : $USERS"
	print "     ${BIN_CHOWN} -R $USERS ./*"
	${BIN_CHOWN} -R ${USERS} ./*
fi

##
## Defining rights to apply to website files
##
if [ ${SECURE_FILES_AND_DIRS} -gt 0 ]; then
	CHMOD_USERS=${DEFAULT_CHMOD_LIST}
	if [ "${CHMOD_USERS}" = "ug" ]; then
		print ""
		print " ++ User and group will be able to write/execute "
		print "    Automne administration files, scripts or public pages"
		BASE_CHMOD_FILES=0660
		BASE_CHMOD_DIRS=0770
	elif [ "${CHMOD_USERS}" = "ugo" ]; then
		print " ++ Anybody  will be able to write/execute "
		print "    Automne administration files, scripts or public pages"
		print "    Careful, not so secure ??"
		BASE_CHMOD_FILES=0666
		BASE_CHMOD_DIRS=0777
	elif [ "${CHMOD_USERS}" = "u" ]; then
		print " ++ Only the owner will be able to write/execute "
		print "    Automne administration files, scripts or public pages"
		BASE_CHMOD_FILES=0600
		BASE_CHMOD_DIRS=0700
	fi
	print ""
	print " ++ Sets default files rights all over website."
	print "    All dirs set to ${BASE_CHMOD_DIRS}."
	print "    And all files set to ${BASE_CHMOD_FILES}."
	find . -type d -mindepth 1 -exec chmod ${BASE_CHMOD_DIRS} {} \;
	find . -type f -exec chmod ${BASE_CHMOD_FILES} {} \;
	## 
	## This script must stay executables
	## 
	if [ -f $0 ] ; then
		chmod ug+rwx $0
	fi
else
	CHMOD_USERS=${DEFAULT_CHMOD_LIST}
fi

## 
## Updating rights to selected files and folders
## 
print ""
print " ++ Updating rights to selected files and folders"
print "    to run Automne properly :"
print "    "`pwd`

for f in `cat -A ${AUTOMNE_PERMISSIONS_FILE}` ; do
	if [ "${f:0:1}" != "#" ] ; then
		action=`echo ${f} |cut -d"^" -f1`
		if [ "${action}" = "ch" ] ; then
			file=`echo ${f} |cut -d"^" -f2`
			filepattern=${file:2:${#file}}
			parameter=`echo ${f} |cut -d"^" -f3`
			let len=(${#parameter} -1)
			parameter=`echo ${parameter:1} |cut -d"$" -f1`
			#print "action:$action filepattern:$filepattern parameter:$parameter "
			
			if [ "${filepattern}" != "" -a "${filepattern}" != "*" -a "${parameter}" != "" ] ; then
				# Execute permission updates
				if [ -d "${filepattern}" ]; then
					echo "    \`-- ${CHMOD_USERS}+${parameter} ./${filepattern} (-R)"
					chmod -R ${CHMOD_USERS}+${parameter} ./${filepattern}
				else
					echo "    \`-- ${CHMOD_USERS}+${parameter} ./${filepattern}"
					chmod ${CHMOD_USERS}+${parameter} ./${filepattern}
				fi
			fi
		fi
	fi
done

# Sets current user owner of all shell scripts
if [ ${SECURE_FILES_AND_DIRS} -gt 0 -a "${USER}" != "" ] ; then
	chown -R ${USER} ./automne_bin/*.sh
	chmod 0700 ./automne_bin/*.sh
fi

print ""
print " Done."
print ""

exit 0