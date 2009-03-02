<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * @version $Id: binlog.lib.php,v 1.1 2009/03/02 12:33:10 sebastien Exp $
 */

/**
 *
 */
class PMA_StorageEngine_binlog extends PMA_StorageEngine
{
    /**
     * returns string with filename for the MySQL helppage
     * about this storage engne
     *
     * @return  string  mysql helppage filename
     */
    function getMysqlHelpPage()
    {
        return 'binary-log';
    }
}

?>
