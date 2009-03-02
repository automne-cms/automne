<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * @version $Id: mrg_myisam.lib.php,v 1.1 2009/03/02 12:33:10 sebastien Exp $
 */

/**
 *
 */
include_once './libraries/engines/merge.lib.php';

/**
 *
 */
class PMA_StorageEngine_mrg_myisam extends PMA_StorageEngine_merge
{
    /**
     * returns string with filename for the MySQL helppage
     * about this storage engne
     *
     * @return  string  mysql helppage filename
     */
    function getMysqlHelpPage()
    {
        return 'merge';
    }
}

?>
