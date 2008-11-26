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
## $Id: cms-database-restore.sh,v 1.1.1.1 2008/11/26 17:12:35 sebastien Exp $

## +----------------------------------------------------------------------+
## | Vars and Parameters                                                  |
## +----------------------------------------------------------------------+

##
## Directory containing sql file to restore
## 
BACKUP_DIR="`pwd`/sql"

##
## Programmes
##
BIN_MYSQL="/usr/bin/mysql"

## 
## Getting vars from script parameters
## And proceed to some tests
while getopts ":qhd:" opt; do
	case $opt in
		d ) BACKUP_DIR="${OPTARG}";;
		q ) QUIET=true;;
		h ) echo ""
			echo "  [USAGE]: $0 [-q] [-d backup_dir]"
			echo "      -q            :   Script keeps quiet, except for errors"
			echo "      -d backup_dir :   Where to get SQL file to restore
			echo "                        Default : ./sql"
			echo ""
			exit 1;;
		\? ) QUIET=false;;
	esac
done
shift $(($OPTIND - 1))

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

## +----------------------------------------------------------------------+
## | Runs                                                                 |
## +----------------------------------------------------------------------+

## Some checks
##
if [ ! -x ${BIN_MYSQL} ] ; then
	echo ""
	echo " Check permissions of program :"
	echo " ${BIN_MYSQL}"
	exit 1
fi

## Get SQL file and dump into DB
##
#SQL_FILE="${BACKUP_DIR}/${APPLICATION_DB_NAME}.backup.sql"
print ""
print " + Search for sql file ${SQL_FILE}"

if [ -f ${SQL_FILE} ] ; then
	print "Command used : ${BIN_MYSQL} -u${APPLICATION_DB_USER} -p${APPLICATION_DB_PASSWORD} ${APPLICATION_DB_NAME} < ${SQL_FILE}"
	${BIN_MYSQL} -u${APPLICATION_DB_USER} -p${APPLICATION_DB_PASSWORD} ${APPLICATION_DB_NAME} < ${SQL_FILE}
	
	print " ++ Database inserted properly"
else
	echo ""
	echo " [EE] No SQL file to restore could be founded : ${SQL_FILE}"
	exit 1
fi

exit 0