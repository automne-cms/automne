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
## $Id: cms-constants.sh,v 1.1.1.1 2008/11/26 17:12:35 sebastien Exp $

##
## get parameters from given php file (ex: cms_rc.php) file for example based on such 
## defined("varname", "value"); syntax
## helps changing PHP constants values in shell vars

## +----------------------------------------------------------------------+
## | Vars and Parameters                                                  |
## +----------------------------------------------------------------------+

CONFIG_PHP_FILE="config.php"
RC_PHP_FILE="cms_rc.php"
RC_ADMIN_PHP_FILE="cms_rc_admin.php"

BIN_GREP="/bin/grep"

## +----------------------------------------------------------------------+
## | Functions                                                            |
## +----------------------------------------------------------------------+

## Print : 
## Outputs a message if quiet not required
function print ()
{
	if [ ! $QUIET ] ; then
		echo "$1"
	fi
}

## Parses constant PHP file
##
## @param string path to file to be parsed
## @return void
function parsePHPConstantsFromFile ()
{
	if [ ! -f $1 ] ; then
		print " [EE] File not found : $1"
	else
		for v in `${BIN_GREP} define\(\" $1 |cut -d"\"" -f2` ; do
			evl="echo \$${v}"
			known_value="`eval ${evl}`"
			if [ "$known_value" == "" ]; then
				value=`${BIN_GREP} define\(\"$v\" $1 |cut -d"\"" -f4`
				if [ "$value" != "" ]; then
					export $v="$value"
				fi
			fi
		done
	fi
	
}

## +----------------------------------------------------------------------+
## | Runs                                                                 |
## +----------------------------------------------------------------------+

# Parses constants from main PHP files, respect current order
parsePHPConstantsFromFile $CONFIG_PHP_FILE
parsePHPConstantsFromFile $RC_PHP_FILE
parsePHPConstantsFromFile $RC_ADMIN_PHP_FILE


# No exit, this file has is called through "source $0"