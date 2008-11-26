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
## $Id: cms-database-dump.sh,v 1.1.1.1 2008/11/26 17:12:35 sebastien Exp $

##
## Export database into ./sql directory

## +----------------------------------------------------------------------+
## | Vars and Parameters                                                  |
## +----------------------------------------------------------------------+

##
## Programmes
##
BIN_MYSQLDUMP="/usr/bin/mysqldump"

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
## Getting vars from script parameters
## And proceed to some tests
while getopts ":qh" opt; do
	case $opt in
		q ) QUIET=true;;
		h ) echo ""
			echo "  [USAGE]: $0 [-q] destination_dir"
			echo "      -q :                Script keeps quiet, except for errors"
			echo "      destination_dir :   Where to let the archive file when done"
			echo "                          Default : ${BACKUP_DIR}"
			echo ""
			exit 1;;
		\? ) QUIET=false;;
	esac
done
shift $(($OPTIND - 1))

## +----------------------------------------------------------------------+
## | Runs                                                                 |
## +----------------------------------------------------------------------+

## Some checks
##
if [ ! -x ${BIN_MYSQLDUMP} ] ; then
	echo ""
	echo " Check permissions of program :"
	echo " ${BIN_MYSQLDUMP}"
	exit 1
fi

## Backup database now
##
SQL_FILE="sql/${APPLICATION_DB_NAME}.backup.sql"

if [ -f ${SQL_FILE} -a ! -w ${SQL_FILE} ] ; then
	chmod u+w ${SQL_FILE}
fi
print ""
print " + Save mysql database as SQL dump"
#print "   Command used : ${BIN_MYSQLDUMP} -u${APPLICATION_DB_USER} -p${APPLICATION_DB_PASSWORD} ${APPLICATION_DB_NAME} --add-drop-table > ${SQL_FILE}"
${BIN_MYSQLDUMP} -u${APPLICATION_DB_USER} -p${APPLICATION_DB_PASSWORD} ${APPLICATION_DB_NAME} --add-drop-table > ${SQL_FILE}

print "   ++ Database available here : "
print "      `pwd`/${SQL_FILE} (`du --si ${SQL_FILE} |cut -f1`)"
print ""

exit 0