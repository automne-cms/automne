#!/bin/sh
unset ATM_SETUP_CALLS

function atmCheckings()
{
	echo -n 'Checkings: '
	if [ ! -d automne ]; then
		echo "This is not an Automne site"
		return 1
	fi

	if [ ! -f config.php ]; then
		echo "You must be in the root folder of the site."
		return 1
	fi

	echo 'Ok'
}

function atmSetConstants()
{
	has_errors=0

	echo "Setting up constants:"

	ATM_BACKUP_FILE_PREFIX="backup_"
	ATM_BACKUP_FILE_EXTENSION="tgz"
	ATM_SQL_DUMP_FILE_PREFIX="dump_"

	ATM_DB_HOST=`grep 'APPLICATION_DB_HOST' config.php		|sed 's/.*APPLICATION_DB_HOST".*"\(.*\)".*/\1/g'`
	ATM_DB_NAME=`grep 'APPLICATION_DB_NAME' config.php		|sed 's/.*APPLICATION_DB_NAME".*"\(.*\)".*/\1/g'`
	ATM_DB_USER=`grep 'APPLICATION_DB_USER' config.php		|sed 's/.*APPLICATION_DB_USER".*"\(.*\)".*/\1/g'`
	ATM_DB_PASS=`grep 'APPLICATION_DB_PASSWORD' config.php	|sed 's/.*APPLICATION_DB_PASSWORD".*"\(.*\)".*/\1/g'`

	if [ "$ATM_DB_HOST" != "" ]; then
		echo "	ATM_DB_HOST: Ok."
	else
		ATM_DB_HOST='localhost'
		echo "	ATM_DB_HOST: NOT FOUND. Set to 'localhost'."
	fi

	if [ "$ATM_DB_NAME" != "" ]; then
		echo "	ATM_DB_NAME: Ok."
	else
		echo "	ATM_DB_HOST: NOT FOUND."
		has_errors=1
	fi

	if [ "$ATM_DB_USER" != "" ]; then
		echo "	ATM_DB_USER: Ok."
	else
		echo "	ATM_DB_USER: NOT FOUND."
		has_errors=1
	fi

	if [ "$ATM_DB_PASS" != "" ]; then
		echo "	ATM_DB_PASS: Ok."
	else
		echo "	ATM_DB_PASS: NOT FOUND."
		has_errors=1
	fi

	return $has_errors
}

function atmSetup()
{
	if [ -z "$ATM_SETUP_CALLS" ]; then
		atmCheckings || return 1

		export ATM_SETUP_CALLS=1

		atmSetConstants
		if [ $? -ne 0 ]; then
			atmTearDown
			return 1
		fi

		export ATM_DATE=`date +%F_%H-%M-%S`
	else
		ATM_SETUP_CALLS=$(($ATM_SETUP_CALLS + 1))
	fi
	return 0
}

# cleanup environement
function atmTearDown()
{
	if [ -z "$ATM_SETUP_CALLS" ] || [ $ATM_SETUP_CALLS -eq 1 ]; then
		unset ATM_DB_HOST
		unset ATM_DB_NAME
		unset ATM_DB_USER
		unset ATM_DB_PASS
		unset ATM_SQL_DUMP_FILE
		unset ATM_SQL_DUMP_FILE_PREFIX
		unset ATM_SQL_LOAD_FILE
		unset ATM_BACKUP_FILE
		unset ATM_BACKUP_FILE_PREFIX
		unset ATM_BACKUP_FILE_EXTENSION
		unset ATM_RESTORE_FILE
		unset ATM_SETUP_CALLS
	else
		ATM_SETUP_CALLS=$(($ATM_SETUP_CALLS - 1))
	fi
	return 0
}

function atmSqlDump()
{
	atmSetup || return 1

	ATM_SQL_DUMP_FILE="sql/$ATM_SQL_DUMP_FILE_PREFIX$ATM_DATE.sql"
	OPTIONS="--add-drop-table --complete-insert $*"

	echo "SQL dump:"
	if [ ! -f "$ATM_SQL_DUMP_FILE" ]; then
		mysqldump $OPTIONS -h$ATM_DB_HOST -u$ATM_DB_USER -p$ATM_DB_PASS $ATM_DB_NAME > "$ATM_SQL_DUMP_FILE"

		if [ $? -eq 0 ]; then
			echo "SUCCESS: file $ATM_SQL_DUMP_FILE."
			atmTearDown
			return 0
		else
			echo "ERROR: SQL dump failure";
			if [ -f "$ATM_SQL_DUMP_FILE" ]; then
				rm "$ATM_SQL_DUMP_FILE"
			fi
			atmTearDown
			return 1
		fi

	else
		echo "ERROR: $ATM_SQL_DUMP_FILE already exists."
		atmTearDown
		return 1
	fi

	atmTearDown
	return 0
}

function atmSqlLoad()
{
	atmSetup || return 1

	#check for file
	if [ -z $1 ] || [ ! -f $1 ]; then
		echo "ERROR: file $1 do not exists";
		atmTearDown
		return 1
	else
		ATM_SQL_LOAD_FILE="$1"
		shift
	fi

	OPTIONS="$*"

	echo "SQL load: "
	mysql $OPTIONS -h$ATM_DB_HOST -u$ATM_DB_USER -p$ATM_DB_PASS $ATM_DB_NAME < "$ATM_SQL_LOAD_FILE"
	if [ $? -eq 0 ]; then
		echo "SUCCESS."
		atmTearDown
		return 0
	else
		echo "ERROR: SQL load failure";
		atmTearDown
		return 1
	fi

	atmTearDown
	return 0
}

function atmBackup()
{
	atmSetup || return 1
	atmSqlDump
	if [ $? -ne 0 ]; then
		atmTearDown
		return 1
	fi

	echo "Backup:"
	ARCHIVE_DIR="../archives"
	if [ -d "$ARCHIVE_DIR" ]; then
		ATM_BACKUP_FILE="$ARCHIVE_DIR/$ATM_BACKUP_FILE_PREFIX$ATM_DATE.$ATM_BACKUP_FILE_EXTENSION"
	else
		ATM_BACKUP_FILE="$ATM_BACKUP_FILE_PREFIX$ATM_DATE.$ATM_BACKUP_FILE_EXTENSION"
	fi

	EXCLUDE_OPTIONS="--exclude=./$ATM_BACKUP_FILE_PREFIX*.tar.gz --exclude=./$ATM_BACKUP_FILE_PREFIX*.$ATM_BACKUP_FILE_EXTENSION --exclude=./.htaccess --exclude=./.htpasswd"

	for ITEM in './automne_linx_files/*' './html/*' './web/*' './automne/cache/*' 'automne/tmp/*' 'automne/upload/*'; do
		atmAsk "Backup $ITEM [y|n]?"
		if [ $? -ne 1 ]; then
			EXCLUDE_OPTIONS="$EXCLUDE_OPTIONS --exclude=$ITEM"
		fi
	done

	OPTIONS="-cz $EXCLUDE_OPTIONS $*"

	if [ ! -f "$ATM_BACKUP_FILE" ]; then
		tar $* $OPTIONS -f "$ATM_BACKUP_FILE" .

		if [ $? -eq 0 ]; then
			echo "SUCCESS: File $ATM_BACKUP_FILE"
			atmTearDown
			return 0
		else
			echo "ERROR: Backup failure";
			if [ -f "$ATM_BACKUP_FILE" ]; then
				rm "$ATM_BACKUP_FILE"
			fi
			atmTearDown
			return 1
		fi
	else
		echo "ERROR: $ATM_BACKUP_FILE already exists."
		atmTearDown
		return 1
	fi

	if [ -f "$ATM_SQL_DUMP_FILE" ]; then
		rm "$ATM_SQL_DUMP_FILE"
	fi

	atmTearDown
	return 0
}

function atmRestore()
{
	atmSetup || return 1
	
	#check for file
	if [ -z $1 ] || [ ! -f $1 ]; then
		echo "ERROR: file $1 do not exists";
		atmTearDown
		return 1
	else
		ATM_RESTORE_FILE="$1"
		shift
		#todo rewrite this in one pass with sed
		ATM_SQL_LOAD_FILE=${ATM_RESTORE_FILE##.*$ATM_BACKUP_FILE_PREFIX}
		ATM_SQL_LOAD_FILE="./sql/$ATM_SQL_DUMP_FILE_PREFIX${ATM_SQL_LOAD_FILE%%\.$ATM_BACKUP_FILE_EXTENSION}.sql"
	fi

	echo "Restore:"

	#backup before?
	atmAsk "Backup before? [y|n]"
	if [ $? -eq 1 ]; then
		atmBackup
		if [ $? -ne 0 ]; then
			atmTearDown
			return 1
		fi
	fi

	#excludes?
	echo "Exclude options"

	EXCLUDE_OPTIONS=""
	for ITEM in './automne_linx_files/*' './html/*' './web/*' './automne/cache/*' 'automne/tmp/*' 'automne/upload/*'; do
		EXCLUDE_OPTIONS="$EXCLUDE_OPTIONS --exclude=$ITEM"
	done

	for ITEM in './index.php' './config.php' './automne/templates/*' './automne_modules_files/*' './js/*' './img/*'; do
		atmAsk "Overide $ITEM [y|n]?"
		if [ $? -ne 1 ]; then
			EXCLUDE_OPTIONS="$EXCLUDE_OPTIONS --exclude=$ITEM"
		fi
	done

	echo "Uncompressing archive"
	OPTIONS="-xm $EXCLUDE_OPTIONS $*" # -m evite utime non dispo sur hubble
	tar $OPTIONS -f "$ATM_RESTORE_FILE" .
	if [ $? -ne 0 ]; then
		atmTearDown
		return 1
	fi

	#overide database?
	if [ -f $ATM_SQL_LOAD_FILE ]; then
		atmAsk "Overide Database [y|n]?"
		if [ $? -eq 1 ]; then
			atmSqlLoad "$ATM_SQL_LOAD_FILE"
		fi
	else
		echo "$ATM_SQL_LOAD_FILE not found."
	fi

	atmTearDown
	return 0
}

function atmAsk()
{
	#todo add default answer support
	wrong_answer=1
	while [ $wrong_answer -eq 1 ]; do
		echo -n "$1 "
		read answer
		case "$answer" in
			"y")
				return 1
			;;
			"Y")
				return 1
			;;
			"n")
				return 0
			;;
			"N")
				return 0
			;;
			* )
				wrong_answer=1
		esac
	done
}
