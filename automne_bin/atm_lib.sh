# +----------------------------------------------------------------------+
# | Automne (TM)                                                         |
# +----------------------------------------------------------------------+
# | Copyright (c) 2000-2009 WS Interactive                               |
# +----------------------------------------------------------------------+
# | Automne is subject to version 2.0 or above of the GPL license.       |
# | The license text is bundled with this package in the file            |
# | LICENSE-GPL, and is available through the world-wide-web at          |
# | http://www.gnu.org/copyleft/gpl.html.                                |
# +----------------------------------------------------------------------+
# | Author: Antoine Cezar <antoine.cezar@ws-interactive.fr>              |
# +----------------------------------------------------------------------+
#
# $Id: atm_lib.sh,v 1.2 2009/10/22 16:24:52 sebastien Exp $

#
# Automne shell commands
#
# To use this file, you must source it: source atm_lib.sh
#
# The following description of the aviable commandes is then displayed:
#     Automne shell commands help.
#     All the commands must be lauched at the root of an Automne website.
#
#     atmHelp
#         Display this message.
#
#     atmSqlBackup [options]
#         Dump the database of an Automne website.
#
#         options    Any mysqldump option. See the mysqldump command help for more informations.
#
#     atmSqlRestore sqlFile [options]
#         Load an sql file into the database of an Automne website.
#
#         options    Any mysql option. See the mysql command help for more informations.
#         sqlFile    The sql file to load.
#
#     atmBackup [options]
#         Backup the Automne website. A tar gziped archive is created in the current
#         directory or in ../archives/ if exists.
#         Some step of the restore process are interactive.
#
#         options    Any tar option. See the tar command help for more informations.
#
#     atmRestore file [options]
#         Restore backup created with atmBackup.
#         Some step of the restore process are interactive.
#
#         file       A tar.gz archive
#         options    Any tar option. See the tar command help for more informations.
#
# @package CMS
# @subpackage Script
# @author Antoine Cezar <antoine.cezar@ws-interactive.fr>
#

unset ATM_SETUP_CALLS

function atmCheckings {
    echo -n 'Checkings: '
    if [ ! -d automne ] || [ ! -f config.php ]; then
        echo "You must be at the root of an Automne website to launch this command"
        return 1
    fi

    echo 'Ok'
}

function atmSetConstants {
    has_errors=0
    ATM_DEBUG=1

    echo "Setting up constants:"

    ATM_BACKUP_FILE_PREFIX="backup_"
    ATM_BACKUP_FILE_EXTENSION="tgz"
    ATM_SQL_DUMP_FILE_PREFIX="dump_"

    ATM_DB_HOST=`grep 'APPLICATION_DB_HOST' config.php      |sed 's/.*APPLICATION_DB_HOST".*"\(.*\)".*/\1/g'`
    ATM_DB_NAME=`grep 'APPLICATION_DB_NAME' config.php      |sed 's/.*APPLICATION_DB_NAME".*"\(.*\)".*/\1/g'`
    ATM_DB_USER=`grep 'APPLICATION_DB_USER' config.php      |sed 's/.*APPLICATION_DB_USER".*"\(.*\)".*/\1/g'`
    ATM_DB_PASS=`grep 'APPLICATION_DB_PASSWORD' config.php  |sed 's/.*APPLICATION_DB_PASSWORD".*"\(.*\)".*/\1/g'`

    if [ "$ATM_DB_HOST" != "" ]; then
        echo "  ATM_DB_HOST: Ok"
    else
        ATM_DB_HOST='localhost'
        echo "  ATM_DB_HOST: NOT FOUND. Set to 'localhost'"
    fi

    if [ "$ATM_DB_NAME" != "" ]; then
        echo "  ATM_DB_NAME: Ok"
    else
        echo "  ATM_DB_HOST: NOT FOUND"
        has_errors=1
    fi

    if [ "$ATM_DB_USER" != "" ]; then
        echo "  ATM_DB_USER: Ok"
    else
        echo "  ATM_DB_USER: NOT FOUND"
        has_errors=1
    fi

    if [ "$ATM_DB_PASS" != "" ]; then
        echo "  ATM_DB_PASS: Ok"
    else
        echo "  ATM_DB_PASS: NOT FOUND"
        has_errors=1
    fi

    return $has_errors
}

function atmSetup {
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
function atmTearDown {
    if [ -z "$ATM_SETUP_CALLS" ] || [ $ATM_SETUP_CALLS -eq 1 ]; then
        echo 'Evironement cleanup:'
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
        echo 'Ok'
    else
        ATM_SETUP_CALLS=$(($ATM_SETUP_CALLS - 1))
    fi
    return 0
}

function atmSqlBackup {
    atmSetup || return 1

    ATM_SQL_DUMP_FILE="sql/$ATM_SQL_DUMP_FILE_PREFIX$ATM_DATE.sql"
    OPTIONS="--add-drop-table --complete-insert $*"

    echo "SQL dump:"
    if [ ! -f "$ATM_SQL_DUMP_FILE" ]; then
        mysqldump $OPTIONS -h$ATM_DB_HOST -u$ATM_DB_USER -p$ATM_DB_PASS $ATM_DB_NAME > "$ATM_SQL_DUMP_FILE"

        if [ $? -eq 0 ]; then
            echo "SUCCESS: file $ATM_SQL_DUMP_FILE"
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
        echo "ERROR: $ATM_SQL_DUMP_FILE already exists"
        atmTearDown
        return 1
    fi

    atmTearDown
    return 0
}

function atmSqlRestore {
    #check for file
    if [ -z $1 ]; then
        atmHelp
        atmTearDown
        return 1
    elif [ ! -f $1 ]; then
        echo "ERROR: file $1 do not exists";
        atmTearDown
        return 1
    else
        ATM_SQL_LOAD_FILE="$1"
        shift
    fi

    atmSetup || return 1

    OPTIONS="$*"

    echo "SQL load: "
    echo "Loading database"
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

function atmBackup {
    atmSetup || return 1
    atmSqlBackup
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

    EXCLUDE_OPTIONS="--exclude=./$ATM_BACKUP_FILE_PREFIX*.tar.gz --exclude=./$ATM_BACKUP_FILE_PREFIX*.$ATM_BACKUP_FILE_EXTENSION --exclude=./.htpasswd"

    for ITEM in './automne_modules_files/' './automne_linx_files/' './html/' './web/' './automne/cache/' './automne/tmp/' './automne/upload/'; do
        atmAsk "Backup $ITEM [Y|n]?" "y"
        if [ $? -ne 1 ]; then
            if [ -f "$ITEM" ]; then
                EXCLUDE_OPTIONS="$EXCLUDE_OPTIONS --exclude=$ITEM"
            elif [ -d "$ITEM" ] && [ ]; then
                if [ $ATM_DEBUG ]; then
                    echo "Excluding files for $ITEM"
                fi
                for FILE in `find $ITEM -type f -print`; do
                    if [ $ATM_DEBUG ]; then
                        echo "    Excluding $FILE"
                    fi
                    EXCLUDE_OPTIONS="$EXCLUDE_OPTIONS --exclude=$FILE"
                done
            fi
        fi
    done

    OPTIONS="-cz $EXCLUDE_OPTIONS $*"

    if [ ! -f "$ATM_BACKUP_FILE" ]; then
        echo "Creating archive"
        tar $* $OPTIONS -f "$ATM_BACKUP_FILE" .

        if [ $? -eq 0 ]; then
            echo "SUCCESS: File $ATM_BACKUP_FILE"
            if [ -f "$ATM_SQL_DUMP_FILE" ]; then
                rm "$ATM_SQL_DUMP_FILE"
            fi
            atmTearDown
            return 0
        else
            echo "ERROR: Backup failure";
            if [ -f "$ATM_BACKUP_FILE" ]; then
                rm "$ATM_BACKUP_FILE"
            fi
            if [ -f "$ATM_SQL_DUMP_FILE" ]; then
                rm "$ATM_SQL_DUMP_FILE"
            fi
            atmTearDown
            return 1
        fi
    else
        echo "ERROR: $ATM_BACKUP_FILE already exists."
        if [ -f "$ATM_SQL_DUMP_FILE" ]; then
            rm "$ATM_SQL_DUMP_FILE"
        fi
        atmTearDown
        return 1
    fi

    atmTearDown
    return 0
}

function atmRestore {
    atmSetup || return 1

    #check for file
    if [ -z $1 ]; then
        atmHelp
        atmTearDown
        return 1
    elif [ ! -f $1 ]; then
        echo "ERROR: file $1 do not exists";
        atmTearDown
        return 1
    else
        ATM_RESTORE_FILE="$1"
        shift
        ATM_SQL_LOAD_FILE=`echo "$ATM_RESTORE_FILE" | sed "s/.*$ATM_BACKUP_FILE_PREFIX\(.*\)\.$ATM_BACKUP_FILE_EXTENSION$/.\/sql\/$ATM_SQL_DUMP_FILE_PREFIX\1.sql/"`
    fi

    echo "Restore:"

    #backup before?
    atmAsk "Backup before? [Y|n]"
    if [ $? -eq 1 ]; then
        atmBackup
        if [ $? -ne 0 ]; then
            atmTearDown
            return 1
        fi
    fi

    #excludes?
    echo "Exclude options"

    ATM_RESTORE_EXCLUDE_LIST="./automne_linx_files/ ./html/ ./web/ ./automne/cache/ ./automne/tmp/ ./automne/upload/"
    for ITEM in './index.php' './config.php' './automne/templates/' './automne_modules_files/' './js/' './img/'; do
        atmAsk "Overide $ITEM [y|N]?" "n"
        if [ $? -ne 1 ]; then
            ATM_RESTORE_EXCLUDE_LIST="$ATM_RESTORE_EXCLUDE_LIST $ITEM"
        fi
    done

    #build exclude options
    ATM_RESTORE_EXCLUDE_FILE="ATM_RESTORE_EXCLUDE_FILE_$ATM_DATE.tmp"

    ATM_RESTORE_FILE_LIST=`tar -tf "$ATM_RESTORE_FILE"`
    for ITEM in `echo "$ATM_RESTORE_EXCLUDE_LIST"`; do
        if [ `expr match "$ITEM" '.*/$'` -ne 0 ]; then
            ITEM_LIST=`echo "$ATM_RESTORE_FILE_LIST" | grep "^$ITEM.*" | grep -v ".*/$"`
            if [ $ATM_DEBUG ]; then
                echo "Excluding files for $ITEM"
                echo "$ITEM_LIST"
                echo ""
            fi
            echo "$ITEM_LIST" >> "$ATM_RESTORE_EXCLUDE_FILE"
        else
            if [ $ATM_DEBUG ]; then
                echo "Excluding $ITEM"
            fi
            echo "$ITEM" >> "$ATM_RESTORE_EXCLUDE_FILE"
        fi
    done
    unset ATM_RESTORE_FILE_LIST

    OPTIONS="-x -z --exclude-from=$ATM_RESTORE_EXCLUDE_FILE $*"

    echo "Extracting archive"
    tar $OPTIONS -f "$ATM_RESTORE_FILE" .

    if [ -f "$ATM_RESTORE_EXCLUDE_FILE" ]; then
        rm $ATM_RESTORE_EXCLUDE_FILE
    fi
    unset ATM_RESTORE_EXCLUDE_FILE

    if [ $? -ne 0 ]; then
        atmTearDown
        return 1
    fi

    #overide database?
    if [ -f $ATM_SQL_LOAD_FILE ]; then
        atmAsk "Overide Database [y|n]?"
        if [ $? -eq 1 ]; then
            atmSqlRestore "$ATM_SQL_LOAD_FILE"
        fi
    else
        echo "$ATM_SQL_LOAD_FILE not found."
    fi

    atmTearDown
    return 0
}

function atmAsk {
    wrong_answer=1
    while [ $wrong_answer -eq 1 ]; do
        echo -n "$1 "
        read answer
        if [ -z "$answer" ]; then
            answer="$2"
        fi
        case "$answer" in
            "y" | "Y" )
                return 1
            ;;
            "n" | "N" )
                return 0
            ;;
            "" )
                wrong_answer=1
        esac

    done
}

if [ -f "./atm_mkpatch.sh" ]; then
	. "./atm_mkpatch.sh"
fi

function atmHelp {
echo "Automne shell commands help.
All the commands must be lauched at the root of an Automne website.

atmHelp
    Display this message.


atmSqlBackup [options]
    Dump the database of an Automne website.

    options    Any mysqldump option. See the mysqldump command help for more informations.

atmSqlRestore sqlFile [options]
    Load an sql file into the database of an Automne website.

    options    Any mysql option. See the mysql command help for more informations.
    sqlFile    The sql file to load.

atmBackup [options]
    Backup the Automne website. A tar gziped archive is created in the current
    directory or in ../archives/ if exists.
    Some step of the restore process are interactive.

    options    Any tar option. See the tar command help for more informations.

atmRestore file [options]
    Restore backup created with atmBackup.
    Some step of the restore process are interactive.

    file       A tar.gz archive
    options    Any tar option. See the tar command help for more informations.
"
}

atmHelp
