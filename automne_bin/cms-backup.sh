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
## $Id: cms-backup.sh,v 1.1.1.1 2008/11/26 17:12:35 sebastien Exp $

##
## Saving Automne MySQL DB and filesystem into one archive
## ex in crontab :
## 0 0 * * * http cd /home/cedric/sandbox/automne ; ./automne_bin/cms-backup.sh

## +----------------------------------------------------------------------+
## | Vars and Parameters                                                  |
## +----------------------------------------------------------------------+

##
## Programmes
##
BIN_TAR=/bin/tar
BIN_MYSQLDUMP=/usr/bin/mysqldump

##
## backup archive will be stored finally in this directory
## 
BACKUP_DIR="/home/backups"

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
while getopts ":qhd:" opt; do
	case $opt in
		d ) BACKUP_DIR="${OPTARG}";;
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

## Emplacement du répertoire contenant les fichiers du site à sauvegarder
## Par défaut, le script est exécuté depuis la racine du site lui-même
##
HTDOCS_DIR="`pwd`"

## +----------------------------------------------------------------------+
## | Runs                                                                 |
## +----------------------------------------------------------------------+

## Some checks
##
if [ ! -x ${BIN_TAR} ] ; then
	echo ""
	echo " Vérifiez la présence et les permissions de l'exécutable tar :"
	echo " ${BIN_TAR}"
	exit 1
fi
if [ ! -x ${BIN_MYSQLDUMP} ] ; then
	echo ""
	echo " Vérifiez la présence et les permissions de l'exécutable mysqldump :"
	echo " ${BIN_MYSQLDUMP}"
	exit 1
fi
if [ ! -d ${HTDOCS_DIR} ] ; then
	echo ""
	echo " Vérifiez l'existance du répertoire de base du site internet :"
	echo " ${HTDOCS_DIR}"
	exit 1
fi
if [ ! -d ${BACKUP_DIR} ] ; then
	echo ""
	echo " Vérifiez l'existance du répertoire de stockage des archives :"
	echo " ${BACKUP_DIR}"
	exit 1
fi

## Start saving all
##
cd ${HTDOCS_DIR}

## Main archive
TARBALL_NAME="${APPLICATION_DB_NAME}.tar.gz"

# Backup de la base de données
SQL_FILE="sql/${APPLICATION_DB_NAME}.backup.sql"
if [ -f ${SQL_FILE} -a ! -w ${SQL_FILE} ] ; then
	chmod u+w ${SQL_FILE}
fi
#print "${BIN_MYSQLDUMP} -u${APPLICATION_DB_USER} -p${APPLICATION_DB_PASSWORD} ${APPLICATION_DB_NAME} --add-drop-table > ${SQL_FILE}"
${BIN_MYSQLDUMP} -u${APPLICATION_DB_USER} -p${APPLICATION_DB_PASSWORD} ${APPLICATION_DB_NAME} --add-drop-table > ${SQL_FILE}

# Backup des fichiers du site internet sauf les images
#${BIN_TAR} -czf ${TARBALL_NAME} * --exclude=automne_modules_files/*

# Backup de l'ensemble des fichiers du site sauf mantis
${BIN_TAR} -czf ${TARBALL_NAME} *

mv ${TARBALL_NAME} ${BACKUP_DIR}/

print ""
print " Full website saved into archive : "
print "  `du --si ${BACKUP_DIR}/${TARBALL_NAME}`"
print ""

exit 0