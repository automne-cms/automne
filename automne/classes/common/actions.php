<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2009 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: actions.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_actions
  *
  * Utility class : used to show a pack of actions,  which are post forms
  *
  * @package CMS
  * @subpackage common
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_actions extends CMS_grandFather
{
	/**
	  * Array of CMS_action
	  *
	  * @var array(string=>CMS_action) The Actions possible indexed by action group label
	  * @access private
	  */
	protected $_actions = array();
	
	/**
	  * Adds an action defined by its group, label and form action attribute
	  *
	  * @param string $group The action group
	  * @param string $label The action label
	  * @param string $formAction The action form action atribute
	  * @return CMS_action The added action.
	  * @access public
	  */
	function &addAction($group, $label, $formAction)
	{
		$added_action = new CMS_action($label, $formAction);
		$this->_actions[$group][] =& $added_action;
		return $added_action;
	}
	
	function getContent()
	{
		if (is_array($this->_actions) && $this->_actions) {
			$content = '<table border="0" cellpadding="0" cellspacing="0"><tr>';
			foreach ($this->_actions as $group=>$group_actions) {
				$content .= '
					<td valign="top">
						<table border="0" cellpadding="2" cellspacing="2">
						<tr>
							<th class="admin">' .$group. '</th>
						</tr>
				';
				$count=0;
				foreach ($group_actions as $action) {
					$count++;
					$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
					$content .= $action->getContent($td_class);
				}
				$content .= '
						</table>
					</td>
					<td><img src="'.PATH_ADMIN_IMAGES_WR.'/pix_trans.gif" width="10" height="1" /></td>
				';
			}
			$content .= '</tr></table>';
			
			return $content;
		}
	}
}

?>