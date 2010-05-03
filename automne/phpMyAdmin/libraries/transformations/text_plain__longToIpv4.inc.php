<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 *
 * @version $Id: text_plain__longToIpv4.inc.php,v 1.1 2009/03/02 12:33:13 sebastien Exp $
 */

/**
 * returns IPv4 address
 *
 * @see http://php.net/long2ip
 */
function PMA_transformation_text_plain__longToIpv4($buffer, $options = array(), $meta = '')
{
    if ($buffer < 0 || $buffer > 4294967295) {
        return $buffer;
    }

    return long2ip($buffer);
}

?>
